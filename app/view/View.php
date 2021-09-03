<?php

Class View

{
    // if loading template fail
    public static function renderViewFail(Exception $e)
    {
        return '<h1>Attention problème de rendu:' . $e->getMessage() . $e->getCode()."</h1>";
    }

    public static function renderViewException(Exception $e, $title, $imageHeader,$message_special)
    {
        // the array is created here because for display code, is better to use parameters in function
        // in the calling renderViewException (class Controller) long switch is used
        $array = array(
            'e' => $e,
            'message_special'=> $message_special,
            'title'=> $title,
            'imageHeader'=> $imageHeader,
            'root'=>"//blog/",
        ); 
        return View::renderView('message/exception.twig', $array);
    }

    // lots of view use same title
    // factorisation with this method
    public static function renderViewMessage($message)
    {
        $title = "Oops, petit problème";
        return View::renderViewMessageTitle($title, $message);
    }

    public static function renderViewMessageTitle($title, $message)
    {
        $array = array(
            'title'=> $title,
            'message'=> $message,
            'root'=>"//blog/",
        ); 
        return View::renderView('message/simpleMessage.twig', $array);
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