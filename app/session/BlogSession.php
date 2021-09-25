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
        if(null === Session::get("user") )
        {
            Session::put("user", new MemberEntity());
        }
        return Session::get("user");
    }
    
    public function setUser($user)
    {    
        //assign token
        $user->setToken(md5(bin2hex(openssl_random_pseudo_bytes(6))));
        Session::put("user",$user);
    }

    public function disconnect()
    {
        Session::forget("user");
        session_destroy();
    }
      
}
Class Session{

    public static function put($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }

    public static function forget($key){
        unset($_SESSION[$key]);
    }
}
