<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 11/01/17
 * Time: 14:04
 */

namespace Aston\Manager;

use Aston\Entity\AuthorEntity;
use Aston\Entity\EntityInterface;

class AuthorEntityManager extends EntityManager
{
    protected $table = 'author';

    public function addEntity(EntityInterface $entity) {

        $query = $this->db->prepare('INSERT INTO author (title, body) VALUES (:title, :body)');
        $query->bindValue(':title', $entity->getTitle());
        $query->bindValue(':body', $entity->getBody());
        $query->execute();

    }

    public function getEntities(array $ids) {

    }

}