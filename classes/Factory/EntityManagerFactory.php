<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 11/01/17
 * Time: 12:05
 */

namespace Aston\Factory;

use Aston\Core\Database;


class EntityManagerFactory
{
    public static function get($entity_class)

    {
        $class_data = explode('\\', $entity_class);
        //$manager_class = 'Aston\Manager\\' . ucfirst($entity_class) . 'Manager';
        $manager_class = 'Aston\Manager\\' . end($class_data) . 'Manager';

        if (class_exists($manager_class)) {
            $db = Database::getConnection('PDO');
            $manager = new $manager_class($db);
            $manager->setDependecyDb($db);
            $manager->checkIntegrity();
            return $manager;
        }
        else {
            throw new \Exception("Mauvais type d'entité donnée à la Factory de manager.");
        }
    }

}