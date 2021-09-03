<?php

require dirname(__DIR__) . '../../vendor/autoload.php';

Abstract Class RedirectionController
{
    public static function getPage404($userSession)
    {
        $array = array(
            'user'=> $userSession,
            'title'=> "Erreur 404, page non trouvé",
            'root'=>"//blog/",
        ); 
        echo View::renderView("message/404.twig" ,$array);
    }
}