<?php

require dirname(__DIR__) . '../../vendor/autoload.php';
Class MemberEntity extends Entity
{
    //from model
    private $id;
    private $login;
    private $password;
    private $type;

    //var for manage user on the website
    private $permission;
    private $token;
    // functions

    public function hydrate(array $data)
    {
        parent::hydrate($data);
        $this->permission();
    }
   
    public function permission()
    {
       switch($this->getType())
       {
           case 'admin':
                $this->setPermission(ADMIN);
            break;
           case 'subscriber':
                $this->setPermission(USER_AUTHENTIFIED);
            break;
            default:
                $this->setPermission(USER_NOT_AUTHENTIFIED);
       }
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of permission
     */ 
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the value of permission
     *
     * @return  self
     */ 
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}