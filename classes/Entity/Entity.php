<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 11/01/17
 * Time: 14:53
 */

namespace Aston\Entity;

use Aston\Factory\EntityManagerFactory;
use Aston\Manager\EntityManagerInterface;
use Aston\Factory\EntityFactory;


abstract class Entity implements EntityInterface
{
    protected $id;
    protected $title;
    protected $manager;


    final public function setDependencyManager(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }

    public function save()
    {
        $this->manager->addEntity($this);
    }

    public static function load($id)

    {
        if (is_numeric($id)) {
            // Attention, la classe renvoyée sera préfixée de son namespace complet!
            $class = get_called_class();
            $manager = EntityManagerFactory::get($class);
            $data = $manager->getEntity($id);
            if (!$data) {
                return false;
            }
            $entity = $class::create($data);
            return $entity;
        } elseif (is_array($id)) {$slimGuard->validateToken($_POST[$csrfNameKey], $_POST[$csrfValueKey]);

        } else {
            throw new \Exception('Mauvais format de donée pour la méthode load().');
        }

    }

    public function delete()
    {
        $this->manager->deleteEntity($this->getId());
    }

    public static function create(array $data)
    {
        if (isset($data['title']) && $data['title']) {
            $class = get_called_class();
            $book = EntityFactory::get($class);
            $book->hydrate($data);
            return $book;
        } else {
            throw new \Exception('Missing key "title" for Class BookEntity.');
        }
    }

    public function hydrate(array $data)
    {

        foreach ($data as $property => $value) {

            $setter = 'set' . ucfirst($property);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $id = (int)$id;
        if ($id > 0) {
            $this->id = $id;
        }
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $title = htmlentities($title);
        if (strlen($title) <= 50) {
            $this->title = $title;
        } else {
            throw new Exception('Le titre ne peut pas dépasser 50 caractères.');

        }
    }
}