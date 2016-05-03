<?php

namespace Application\FormsBundle\Entity;

use FOS\UserBundle\Model\User as BaseUSer;

/**
 * User
 */
class User extends BaseUSer
{
    /**
     * @var int
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_ADMIN');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

