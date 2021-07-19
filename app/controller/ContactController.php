<?php

require dirname(__DIR__) . '../../vendor/autoload.php';


 Class ContactController
{
    //FORM
    public static function formContact()
    {
        echo ContactView::formContact();
    }
    
    public static function sendMessage($nom, $mail, $contenu)
    {
        echo 'send message';
    }



}