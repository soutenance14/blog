<?php
namespace App\Controller;

use App\View\View;

require dirname(__DIR__) . '../../vendor/autoload.php'; 

Abstract Class RedirectionController
{
    private static $root = null;

    public static function getPage404($userSession)
    {
        $array = array(
            'user'=> $userSession,
            'title'=> "Erreur 404, page non trouvé",
            'root'=>self::getRoot(),
        ); 
        echo View::renderView("message/404.twig" ,$array);
    }

    public static function getRoot()
    {
        if(self::$root === null)
        {
            require dirname(__DIR__) . "../config/configRoot.php";
            self::$root = $root;
        }
        return self::$root;
    }
}