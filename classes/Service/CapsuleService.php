<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 13/01/17
 * Time: 13:57
 */

namespace Aston\Service;

use Illuminate\Database\Capsule\Manager as Capsule;


class CapsuleService implements ServiceInterface
{

    public static function getLibrary() {

        $capsule = new Capsule();
        $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => 'mysql.server.com',
        'database'  => 'aston',
        'username'  => 'olive',
        'password'  => 'tonton',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    }

}