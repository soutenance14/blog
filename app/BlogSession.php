<?php

define('USER_NOT_AUTHENTIFIED', null);
define('USER_AUTHENTIFIED', 1);
define('ADMIN', 2);

session_start();
Class BlogSession
{
    public function getUser()
    {
        if( !isset($_SESSION['user'])   )
        {
            $_SESSION['user'] = new MemberEntity();
        }
        return $_SESSION['user'];
    }
    
    public function setUser($user)
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

