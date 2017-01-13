<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 02/12/16
 * Time: 11:00
 */

namespace Aston\Service;

use Slim\Csrf\Guard;


class CsrfService implements ServiceInterface
{

    public static function getLibrary()
    {
        $slimGuard = new Guard;
        return $slimGuard;
    }

}