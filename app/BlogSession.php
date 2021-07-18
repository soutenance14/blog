<?php

// require "entity/MemberEntity.php";
// define('USER_NO_AUTHENTIFIED_SESSION', null);
session_start();
Class BlogSession
{
    private $user;

    public function getUser()
    {
        if( !isset($_SESSION['user'])   )
        {
            $_SESSION['user'] = new MemberEntity();
        }
        return $_SESSION['user'];
    }
    
    public function setUserAuth($user)
    {    
        //assign token
        $user->setToken(md5(bin2hex(openssl_random_pseudo_bytes(6))));
        $_SESSION['user'] = $user;
    }

    public function disconnect()
    {
        session_destroy();
    }

}

