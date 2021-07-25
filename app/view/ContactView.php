<?php

Class ContactView
{
    public static function formContact($user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('contact/contact.twig');
        
            // set template variables
            // render template
            echo $template->render(array(
                'title'=> 'Contact',
                'user'=> $user,
            ));
        
        }
         catch (Exception $e) 
        {
           echo View::renderViewFail($e);
        }
        // return "Contact
        // <form action ='sendMessage' method ='post'><input name='nom'><input name='mail'><input name='contenu'><input type='submit' name ='submit' value='ok'>
        // </form>";


    }

}