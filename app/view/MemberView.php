<?php

Class MemberView
{

    public static function home($user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('home.twig');
        
            // set template variables
            // render template
            echo $template->render(array(
                'user'=> $user,
            ));
        
        } catch (Exception $e) 
        {
           echo PostView::renderViewFail($e);
        }
    }

    public static function login()
    {
        return "login
        <form action ='auth' method ='post'><input name='login'><input name='password'><input type='submit' name ='submit' value='ok'>
        </form>";
    }
   
    public static function formDelete($user)
    {
        return "Entrer vos login et password pour supprimer le compte<br>
        <form action ='deleteMember/".$user->getToken()."' method ='post'><input name='login'><input name='id' value='".$user->getId()."'>
        <input type='submit' name ='submit' value='Valider la suppréssion'>
        </form>";
    }

    public static function formDeleteBack($user, $listSubscriberEntity)
    {
        $listsSubscribersview = 'Choisir le membre à supprimer.<br>';
        foreach($listSubscriberEntity as $subscriberEntity)
        {
            $listsSubscribersview.= $subscriberEntity->getLogin. 
            "<form action ='deleteMember/".$user->getToken()."' method ='post'>
            Entrer de nouveau le login pour valider la suppréssion
            <input name='login'><input name='id' value='".$user->getId()."'>
                <input type='submit' name ='submit' value='Valider la suppréssion'>
            </form>";
        }

    }
    
    public static function signUp()
    {
        return "Sign Up
        <form action ='pushMember' method ='post'><input name='login'><input name='password'><input type='submit' name ='submit' value='ok'>
        </form>";
    }
    
    public static function memberExist($login)
    {
        return "Le login ".$login." est déja utilisé, veuillez en changer<br>.
        <form action ='pushMember' method ='post'><input name='login'><input name='password'><input type='submit' name ='submit' value='ok'>
        </form>
        ";
    }

    public static function formEditPassword( $user)
    {
        try 
        {
            // le dossier ou on trouve les templates
            $loader = new Twig\Loader\FilesystemLoader('template');
        
            // initialiser l'environement Twig
            $twig = new Twig\Environment($loader);
        
            // load template
            $template = $twig->load('editPassword.twig');
        
            // set template variables
            // render template
            return $template->render(array(
                'user'=> $user,
            ));
        
        }
         catch (Exception $e) 
        {
           return View::renderViewFail($e);
        }

        // return "formEditPassword
        // <form action ='editPassword' method ='post'><input name='oldPassword'><input name='newPassword'><input name='confirmNewPassword'>
        // <input type='submit' name ='submit' value='ok'>
        // <br> <input name ='token' value='".$token."'>
        // </form>";
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