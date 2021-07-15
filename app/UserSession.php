<?php

define('USER_NO_AUTHENTIFIED_SESSION', null);
session_start();
Class UserSession
{
    private static $user;

    public static function getUser()
    {
        if( !isset($_SESSION['user'])   )
        {
            $_SESSION['user'] = USER_NO_AUTHENTIFIED_SESSION;
        }
        return $_SESSION['user'];
    }
    
    public static function setUser($user)
    {    
        $_SESSION['user'] = $user;
    }

    public static function disconnect()
    {
        session_destroy();
    }

}