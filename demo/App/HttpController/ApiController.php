<?php

namespace App\HttpController;

use App\Constants\BaseConstant;
use App\Library\Base\BaseController;
use App\Utils\CustomDataSerializer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ApiController extends BaseController
{
    public $fractal;

    public function __construct()
    {
        $this->fractal = new Manager();
        $this->fractal->setSerializer(new CustomDataSerializer());
    }

    protected function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);
        return $rootScope->toArray();
    }

    protected function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);
        $rootScope = $this->fractal->createData($resource);
        return $rootScope->toArray();
    }

    public function resOk(array $data = [], string $msg = null, $pagination = null)
    {
        return $this->writeJson(BaseConstant::STATUS_CODE_SUCCESS, $data, $msg, $pagination);
    }

    public function resErr(array $data = [], string $msg = null)
    {
        return $this->writeJson(BaseConstant::STATUS_CODE_ERROR, $data, $msg);
    }
}
