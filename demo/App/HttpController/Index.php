<?php

namespace App\HttpController;

use App\Constants\BaseConstant;

class Index extends ApiController
{
    public function index()
    {
        $data = [
            'environment' => getenv('APP_ENV'),
            'php_version' => PHP_VERSION,
            'mysql_version' => \Wy::$app->db::selectOne("select version() as v;")->v,
            'redis_version' => \Wy::$app->redis->info()['redis_version']
        ];

        return $this->resOk($data, 'welcome to ' . getenv('HOST') . '!');
    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(BaseConstant::STATUS_CODE_NOT_FOUND);
        $file = EASYSWOOLE_ROOT . '/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if (!is_file($file)) {
            $file = EASYSWOOLE_ROOT . '/src/Resource/Http/404.html';
        }

        $this->response()->write(file_get_contents($file));
    }
}
