<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 30/11/16
 * Time: 14:24
 */

namespace Aston\Manager;

use Aston\Entity\EntityInterface;


abstract class EntityManager implements EntityManagerInterface
{
    protected $db;

    final public function setDependencyDb(\PDO $db) {
        $this->db = $db;
        $this->checkIntegrity();
    }

    public function addEntity(EntityInterface $entity) {

    }

    public function getEntity($id) {
        $id = (int)$id;
        if($id > 0) {
            $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $query->bindValue(':id', $id, \PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            //\Kint::dump($result);
            return $result;
        }
    }
    public function getEntities(array $ids) {

    }
    public function deleteEntity($id) {
        $id = (int)$id;
        if ($id > 0) {
            $query = $this->db->prepare("DELETE FROM {$this->table} WHERE id=:id");
            $query->bindValue(':id', $id);
            $query->execute();
        }
    }

    final public function checkIntegrity() {
        if(!property_exists(get_called_class(), 'table') || $this->table) {
            throw new \Exception("Les classes Manager d'entités doivent obligatoirement donner une valeur à la propriété 'table'. Cf: " . get_called_class() . '.');
        }
    }

    public function getLastEntities($offset, $limit) {
        $limit = (int)$limit;
        $offset = (int)$offset;

        if ($limit > 0 && is_numeric($offset)) {

            $query = $this->db->prepare("SELECT * FROM {$this->table} LIMIT :offset, :limit");
            $query->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $query->bindValue(':limit', $limit, \PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } else {
            throw new \Exception('Mauvais type de donnée pour la limite.');
        }

    }

}