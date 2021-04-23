<?php

namespace App\Library\Base;

use EasySwoole\Http\AbstractInterface\Controller;

class BaseController extends Controller
{
    public function middlewares()
    {
        return [];
    }

    public function beforeAction(string $actionName)
    {
        if (!parent::beforeAction($actionName)) {
            return false;
        }

        $middleware_chain = [];
        foreach ($this->middlewares() as $middleware) {
            if (is_array($middleware[0])) {
                if (!in_array($actionName, $middleware[0])) {
                    continue;
                }
            } else {
                if (!($actionName == $middleware[0] || $middleware[0] == '*')) {
                    continue;
                }
            }

            array_push($middleware_chain, $middleware[1]);
        }

        foreach ($middleware_chain as $handle) {
            if ($handle instanceof \Closure) {
                $res = $handle();
            } else {
                $tmp = new $handle;
                $res = $tmp->handle($this->request(), $this->response());
            }

            if ($res === false) {
                return false;
            }
        }

        return true;
    }
}
