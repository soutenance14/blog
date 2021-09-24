<?php

namespace App\View;

use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

Abstract Class View
{
    private static $root = null;
    
    // if loading template fail
    public static function renderViewFail(Exception $e)
    {
        return '<h1>Attention problème de rendu:' . $e->getMessage() . $e->getCode()."</h1>";
    }

    public static function renderViewException(Exception $e, $title, $imageHeader,$message_special)
    {
        // array because for is better for display code
        $array = array(
            'e' => $e,
            'message_special'=> $message_special,
            'title'=> $title,
            'imageHeader'=> $imageHeader,
            'root'=>self::getRoot(),
        ); 
        return self::renderView('message/exception.twig', $array);
    }

    // lots of view use same title
    // factorisation with this method
    public static function renderViewMessage($array)
    {
        return self::renderView('message/simpleMessage.twig', $array);
    }

    public static function renderView($pathFileTwig, $array)
    {
        try
        {
            // le dossier ou on trouve les templates
           
            $loader = new FilesystemLoader('../app/template');
            
            // initialiser l'environement Twig
            $twig = new Environment($loader);
        
            // load template
            $template = $twig->load($pathFileTwig);
        
            return $template->render($array); 
        }catch (Exception $e) 
        {
           return self::renderViewFail($e);
        }
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

    public static function success()
    {
        // return simple text wihout render
        // for ajax request
        return "success";
    }
    
    public static function error()
    {
        // return simple text wihout render
        // for ajax request
        return "error";
    }
}