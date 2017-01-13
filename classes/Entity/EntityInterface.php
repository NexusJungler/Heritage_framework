<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 30/11/16
 * Time: 13:58
 */

namespace Aston\Entity;


interface EntityInterface
{
    public static function create(array $data);
    public static function load($id);
    public function save();
    public function delete();

}