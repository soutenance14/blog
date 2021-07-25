<?php

Class MemberView
{

    public static function home($user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('member/home.twig');
        
            // set template variables
            // render template
            echo $template->render(array(
                'title'=> 'Accueil',
                'user'=> $user,
            ));
        
        } catch (Exception $e) 
        {
           echo PostView::renderViewFail($e);
        }
    }

    public static function login()
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('member/login.twig');
        
            // set template variables
            // render template
            echo $template->render(array(
                'title'=> 'S\'identifier',
            ));
        
        } catch (Exception $e) 
        {
           echo PostView::renderViewFail($e);
        }
    }
    
    public static function signUp()
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('member/signUp.twig');
        
            // set template variables
            // render template
            echo $template->render(array(
                'title'=> 'Devenir membre',
            ));
        
        } catch (Exception $e) 
        {
           echo PostView::renderViewFail($e);
        }
        // return "Sign Up
        // <form action ='pushMember' method ='post'><input name='login'><input name='password'><input type='submit' name ='submit' value='ok'>
        // </form>";
    }
    
    public static function memberExist($login)
    {
        return "Le login ".$login." est déja utilisé, veuillez en changer<br>.";
    }

    public static function formEditPassword( $user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('../app/template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('member/editPassword.twig');
        
            // set template variables
            // render template
            return $template->render(array(
                'title'=> 'Modifier Mot de passe',
                'user'=> $user,
            ));
        
        }
         catch (Exception $e) 
        {
           return View::renderViewFail($e);
        }
    }

    public static function pushFail()
    {
        return 'Le push a échoué';  
    }

    public static function deleteFail($login, $id)
    {
        return 'La suppression du compte de '.$login.', id: ".$id." a échoué';  
    }
    
    public static function wrongLoginForUser($login, $id)
    {
        return 'Le login et l\'id ne correspondent pas.';  
    }

    
    public static function editPasswordFail()
    {
        return 'L\'edition  a échoué';  
    }
    
    // public static function deleteFail()
    // {
    //     return 'La suppression a échoué';  
    // }
    
}