<?php

namespace Aston\Core;

/**
 * Created by PhpStorm.
 * User: aston
 * Date: 29/11/16
 * Time: 11:17
 */
class Database
{
    private static $class;
    private static $connection = null;

    // public function __construct($class)
    // {
    //     $this->class = $class;
    // }

    public static function getConnection($class)
    {
        self::$class = $class;

        if (is_null(self::$connection)) {
            self::$connection = new self::$class("mysql:host=mysql.server.com;dbname=aston;", "olive", "tonton");
        }

        return self::$connection;
    }

}