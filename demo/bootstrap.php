<?php

use App\Library\Base\BaseWy;
use App\Library\DB;
use App\Library\JWT;
use App\Library\Redis;
use App\Library\WeChat;

date_default_timezone_set('Asia/Shanghai');

class Wy extends BaseWy
{
}

class Application
{
    public $db;
    public $redis;
    public $wechat;
    public $jwt;

    public function __construct()
    {
        Wy::$app = $this;
    }

    public function run()
    {
        $this->db = DB::getInstance()->db;
        $this->redis = Redis::getInstance();
        $this->wechat = WeChat::getInstance();
        $this->jwt = JWT::getInstance();
    }
}

(new Application())->run();
