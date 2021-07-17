<?php

// namespace App\Session;

define('USER_NO_AUTHENTIFIED_SESSION', null);
session_start();
Class BlogSession
{
    private $user;

    public function getUser()
    {
        if( !isset($_SESSION['user'])   )
        {
            $_SESSION['user'] = USER_NO_AUTHENTIFIED_SESSION;
        }
        return $_SESSION['user'];
    }
    
    public function setUser($user)
    {    
        $_SESSION['user'] = $user;
    }

    public function disconnect()
    {
        session_destroy();
    }

}