<?php

namespace App\Library\InterfaceAbstract;

interface MiddlewareInterface
{
    public function handle($request, $response);
}
