<?php

Class View

{
    public static function renderViewFail(Exception $e)
    {
        return 'Pb render:' . $e->getMessage() . $e->getCode();
    }

    
    public static function renderViewException(Exception $e, $title, $imageHeader,$message_special)
    {
        // le dossier ou on trouve les templates
        $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
        // initialiser l'environement Twig
        $twig = new Twig\Environment($loader);
    
        // load template
        $template = $twig->load('exception/exception.twig');
    
        return $template->render(array(
            'e' => $e,
            'message_special'=> $message_special,
            'title'=> $title,
            'imageHeader'=> $imageHeader,
            'root'=>"../",
        ));
    }


}