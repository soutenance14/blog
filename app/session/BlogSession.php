<?php
namespace App\Session;

use App\Entity\MemberEntity;
use Symfony\Component\HttpFoundation\Session\Session;

define('USER_NOT_AUTHENTIFIED', null);
define('USER_AUTHENTIFIED', 1);
define('ADMIN', 2);

Class BlogSession
{
    private $session;
    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();
    } 

    public function getUser()
    {
        if( null === $this->session->get("user"))
        {
            $this->session->set("user", new MemberEntity());
        }
        return $this->session->get("user");
    }
    
    public function setUser($user)
    {    
        //assign token
        $user->setToken(md5(bin2hex(openssl_random_pseudo_bytes(6))));
        $this->session->set("user", $user);
    }

    public function disconnect()
    {
        $this->session->clear();
        $this->session->invalidate();
    }
      
}
// Class Session{

//     public static function put($key, $value){
//         $_SESSION[$key] = $value;
//     }

//     public static function get($key){
//         return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
//     }

//     public static function forget($key){
//         unset($_SESSION[$key]);
//     }
// }
