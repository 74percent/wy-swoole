<?php

namespace App\Library;

use App\Library\InterfaceAbstract\SingleInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class DB implements SingleInterface
{
    public $db;
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
        $this->db = new Capsule();
        $this->db->addConnection([
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
            'prefix' => getenv('DB_PREFIX'),
        ], 'default');

        $this->db->setAsGlobal();
        $this->db->bootEloquent();
    }
}
