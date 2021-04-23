<?php

namespace App\Library;

use App\Library\InterfaceAbstract\SingleInterface;

class Redis implements SingleInterface
{
    public $redis;
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect(
            getenv('REDIS_HOST'),
            getenv('REDIS_PORT'),
            1,
            NULL,
            0,
            0,
            ['auth' => getenv('REDIS_PASSWORD')]
        );

        $this->redis->select(getenv('REDIS_DATABASE'));
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    public function info()
    {
        return $this->redis->info();
    }

    public function get(string $key)
    {
        return json_decode($this->redis->get($key));
    }

    public function set(string $key, $value, $exprie = null)
    {
        return $this->redis->set($key, json_encode($value), $exprie);
    }

    public function del(string $key)
    {
        return $this->redis->del($key);
    }

    public function incr(string $key, $exprie = null)
    {
        $this->redis->incr($key);
        if ($exprie) {
            $this->redis->expire($key, $exprie);
        }
    }
}
