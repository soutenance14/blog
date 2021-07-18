<?php

require dirname(__DIR__) . '../../vendor/autoload.php';
Class CommentEntity extends Entity
{
    private $id;
    private $id_membre;
    private $id_post;
    private $created_at;
    private $contenu;
    private $login;
    private $published;

    // functions

    public function hydrate(array $data)
    {
        parent::hydrate($data);
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
     * Get the value of idMembre
     */ 
    public function getIdMembre()
    {
        return $this->id_membre;
    }

    /**
     * Set the value of idMembre
     *
     * @return  self
     */ 
    public function setIdMembre($id_membre)
    {
        $this->id_membre = $id_membre;

        return $this;
    }

    /**
     * Get the value of idPost
     */ 
    public function getIdPost()
    {
        return $this->id_post;
    }

    /**
     * Set the value of idPost
     *
     * @return  self
     */ 
    public function setIdPost($id_post)
    {
        $this->id_post = $id_post;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of contenu
     */ 
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set the value of contenu
     *
     * @return  self
     */ 
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

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
     * Get the value of published
     */ 
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set the value of published
     *
     * @return  self
     */ 
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }
}