<?php
namespace App\Session;

use App\Entity\MemberEntity;
use Symfony\Component\HttpFoundation\Session\Session;

define('USER_NOT_AUTHENTIFIED', null);
define('USER_AUTHENTIFIED', 1);
define('ADMIN', 2);

Class BlogSession
{
    private static $session;
    // private $root;
    
    public static function initSession()
    {
        if(null === self::$session)
        {
            self::$session = new Session();
            self::$session->start();
        }
    }

    public static function getUser()
    {
        self::initSession();
        if( null === self::$session->get("user"))
        {
            self::$session->set("user", new MemberEntity());
        }
        return self::$session->get("user");
    }
    
    public static function setUser($user)
    {    
        //assign token
        self::initSession();
        $user->setToken(md5(bin2hex(openssl_random_pseudo_bytes(6))));
        self::$session->set("user", $user);
    }

    public static function disconnect()
    {
        self::initSession();
        self::$session->clear();
        self::$session->invalidate();
    }
    
    // public function getRoot()
    // {
    //     if($this->root === null)
    //     {
    //         require dirname(__DIR__) . "../config/configRoot.php";
    //         $this->root = ROOT;
    //     }
    //     return $this->root;
    // }
}
