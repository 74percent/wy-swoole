1. ###### git clone git@github.com:74percent/wy-swoole.git

2. ###### composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

3. ###### composer install

4. ###### php vendor/bin/easyswoole install（DO NOT COVER ANY FILE）

###### then vim easyswoole Controller add function 'beforeAction' as follow

```
protected function beforeAction(string $actionName)
{
    return true;
}
```

###### and vim the Controller function '\_\_exec' like this

```
if ($this->onRequest($actionName) !== false && $this->beforeAction($actionName) !== false) {
    $forwardPath = $this->$actionName();
} else {
    $forwardPath = $this->actionNotFound($actionName);
}
```

###### and vim the Controller function 'writeJson' like this

```
protected function writeJson($statusCode = 200, $result = null, $msg = null, $pagination = null)
{
    if (!$this->response()->isEndResponse()) {
        $data = [
            "code" => $statusCode,
            "data" => $result,
            "msg" => $msg
        ];
        if ($pagination) $data['pagination'] = $pagination;

        $this->response()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $this->response()->withHeader('Content-type', 'application/json;charset=utf-8');
        $this->response()->withStatus($statusCode);
        return true;
    } else {
        return false;
    }
}
```

###### \* when composer update, the above three steps must be repeated.

```
// validate see https://gitee.com/photondragon/webgeeker-validation
use WebGeeker\Validation\Validation;
Validation::validate($params, [
	'code' => 'Required'
]);

// transformer see https://fractal.thephpleague.com/transformers/
return $this->resOk(
    [
        'list' => $this->respondWithCollection($res, new WithdrawTransformer()),
    ],
    null,
    $this->respondWithItem($pagination, new PaginationTransformer())
);

// middlewares see code
public function middlewares()
{
    return [
        [['info', 'wechatAuth', 'wechatBindPhone'], '\App\Middlewares\IsLoginMiddleware'],
    ];
}

// about wechat see https://www.easywechat.com/docs
$app = \Wy::$app->wechat->getMiniProgramApp();

// about db see https://packagist.org/packages/illuminate/database
\Wy::$app->db

......
```
