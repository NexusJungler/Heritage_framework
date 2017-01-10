<?php

namespace Aston\Manager;

use Aston\Entity\BookEntity;
use Aston\Entity\EntityInterface;
use Aston\Factory\EntityFactory;

/**
 * Class BookEntityManager.
 */
class BookEntityManager extends EntityManager
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function addEntity(EntityInterface $entity)
    {
        $query = $this->db->prepare('INSERT INTO book (title, author, body, genre) VALUES (:title, :author, :body, :genre)');
        $query->bindValue(':title', $entity->getTitle());
        $query->bindValue(':author', $entity->getAuthor());
        $query->bindValue(':body', $entity->getBody());
        $query->bindValue(':genre', $entity->getGenre());

        $executed = $query->execute();
        // $errors = $db->errorInfo();
        // Kint::dump($errors);
        // Kint::dump($executed);
    }

    public function getEntity($id)
    {
    }

    public function getEntities(array $ids)
    {
    }

    public function getLastEntities($offset, $limit)
    {
        $limit = (int)$limit;
        $offset = (int)$offset;

        if ($limit > 0 && is_numeric($offset)) {

            $query = $this->db->prepare('SELECT * FROM book LIMIT :offset, :limit');
            $query->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $query->bindValue(':limit', $limit, \PDO::PARAM_INT);

            $executed = $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);

            $books = [];
            if ($result) {
                foreach ($result as $book) {
                    $entity = EntityFactory::get('bd');
                    $entity->hydrate($book);
                    $books[] = $entity;
                }
            }

            return $books;
        } else {
            throw new \Exception('Mauvais type de donnée pour la limite.');
        }
    }

    public function deleteEntity($id) {
        $id = (int)$id;

        if ($id > 0) {
            $query = $this->db->prepare('DELETE FROM book WHERE id=:id');
            $query->bindValue(':id', $id);
            $query->execute();
        }
    }
}