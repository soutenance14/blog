<?php

Class View

{
    public static function renderViewFail(Exception $e)
    {
        return '<h1>Attention problème de rendu:' . $e->getMessage() . $e->getCode()."</h1>";
    }

    public static function renderViewException(Exception $e, $title, $imageHeader,$message_special)
    {
        // // le dossier ou on trouve les templates
        // $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
        // // initialiser l'environement Twig
        // $twig = new Twig\Environment($loader);
    
        // // load template
        // $template = $twig->load('exception/exception.twig');
    
        // return $template->render(array(
        $array = array(
            'e' => $e,
            'message_special'=> $message_special,
            'title'=> $title,
            'imageHeader'=> $imageHeader,
            'root'=>"../",
        ); 
        return View::renderView('exception/exception.twig', $array);
    }

    public static function renderView($pathFileTwig, $array)
    {
        try
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
            
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load($pathFileTwig);
        
            return $template->render($array); 
        }catch (Exception $e) 
        {
           return PostView::renderViewFail($e);
        }
    }
}