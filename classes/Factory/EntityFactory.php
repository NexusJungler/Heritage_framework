<?php

namespace Aston\Factory;


/**
 * Created by PhpStorm.
 * User: aston
 * Date: 29/11/16
 * Time: 14:47
 */
class EntityFactory
{
    public static function get($entity_class)
    {

        if (class_exists($entity_class)) {
            $manager = EntityManagerFactory::get($entity_class);
            $entity = new $entity_class($manager);
            $entity->setDependencyManager($manager);
            return $entity;
        }
        else {
            throw new \Exception("Mauvais type d'entité donné à la Factory d'entité.");
        }
    }
}