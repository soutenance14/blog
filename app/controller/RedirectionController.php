<?php

namespace App\Controller;

use App\View\View;

Abstract Class RedirectionController
{
    public static function getPage404()
    {
        $array = array('title'=> "Erreur 404, page non trouvé",); 
        return(View::renderView("message/404.twig" ,$array));
    }
}