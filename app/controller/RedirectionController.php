<?php

namespace App\Controller;

use App\View\View;

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
        return(View::renderView("message/404.twig" ,$array));
    }

    public static function getRoot()
    {
        if(self::$root === null)
        {
            require dirname(__DIR__) . "../config/configRoot.php";
            self::$root = ROOT;
        }
        return self::$root;
    }
}