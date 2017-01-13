<?php
/**
 * Created by PhpStorm.
 * User: aston
 * Date: 11/01/17
 * Time: 14:04
 */

namespace Aston\Entity;

use Aston\Factory\EntityFactory;
use Aston\Manager\AuthorEntityManager;

class AuthorEntity extends Entity
{
    private $body;
    protected $manager;

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


}