<?php

namespace App\Middlewares;

use App\Constants\BaseConstant;
use App\Library\InterfaceAbstract\MiddlewareInterface;

class IsLoginMiddleware implements MiddlewareInterface
{
    public function handle($request, $response)
    {
        $flag = true;
        $statusCode = BaseConstant::STATUS_CODE_UNAUTHORIZED;

        $header = $request->getHeaders();
        if (empty($header['authorization'][0])) {
            $flag = false;
            $msg = '认证失败';
        } else {
            try {
                \Wy::$app->jwt->decode($header['authorization'][0]);
            } catch (\Exception $e) {
                $flag = false;
                $msg = '认证失败';
            }
        }

        if ($flag == false) {
            $response->write(json_encode([
                'code' => $statusCode,
                'data' => [],
                'msg' => $msg,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            $response->withHeader('Content-type', 'application/json;charset=utf-8');
            $response->withStatus($statusCode);
            $response->end();
        }

        return $flag;
    }
}
