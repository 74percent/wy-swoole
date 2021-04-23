<?php

namespace App\Library;

use App\Library\InterfaceAbstract\SingleInterface;
use EasyWeChat\Factory;

class WeChat implements SingleInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private $config;

    public function __construct()
    {
        $config = [
            'app_id' => getenv('WECHAT_APP_ID'),
            'secret' => getenv('WECHAT_APP_SECRET'),
            'token' => 'token',
            'response_type' => 'array',
            'log' => [
                'default' => getenv('APP_ENV', 'prod'),
                'channels' => [
                    'dev' => [
                        'driver' => 'single',
                        'path' => 'Log/easywechat.log',
                        'level' => 'debug',
                    ],
                    'prod' => [
                        'driver' => 'daily',
                        'path' => 'Log/easywechat.log',
                        'level' => 'info',
                    ],
                ],
            ],
        ];

        $this->config = $config;
    }

    public function getOfficialAccountApp()
    {
        $app = Factory::officialAccount($this->config);
        return $app;
    }

    public function getMiniProgramApp()
    {
        $app = Factory::miniProgram($this->config);
        return $app;
    }

    public function getPaymentApp()
    {
        $config = [
            'mch_id' => getenv('WXPAY_MCH_ID'),
            'key' => getenv('WXPAY_KEY'),
            'cert_path' => getenv('WXPAY_CERT_PATH'),
            'key_path' => getenv('WXPAY_KEY_PATH'),
            'sandbox' => getenv('WXPAY_SANDBOX', 0) == 1 ? true : false
        ];
        if ($config['sandbox'] == true) {
            $config['key'] = Factory::payment($config)->sandbox->getKey();
        }

        foreach ($config as $k => $v) {
            $this->config[$k] = $v;
        }

        $app = Factory::payment($this->config);
        return $app;
    }
}
