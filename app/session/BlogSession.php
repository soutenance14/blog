<?php
namespace App\Session;

use App\Entity\MemberEntity;

define('USER_NOT_AUTHENTIFIED', null);
define('USER_AUTHENTIFIED', 1);
define('ADMIN', 2);

session_start();
Class BlogSession
{
    public function getUser()
    {
        $session = $_SESSION;
        if( !isset($session['user'])   )
        {
            $session['user'] = new MemberEntity();
        }
        return $session['user'];
    }
    
    public function setUser($user)
    {    
        $session = $_SESSION;
        //assign token
        $user->setToken(md5(bin2hex(openssl_random_pseudo_bytes(6))));
        $session['user'] = $user;
    }

    public function disconnect()
    {
        session_destroy();
    }

}

