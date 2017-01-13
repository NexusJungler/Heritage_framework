<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 11/01/17
 * Time: 15:04
 */

namespace Aston\Manager;

use Aston\Entity\EntityInterface;

interface EntityManagerInterface
{
    public function addEntity (EntityInterface $entity);
    public function getEntity ($id);
    public function getEntities(array $ids);
    public function deleteEntity($id);

}