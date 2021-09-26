<?php
namespace App\View;

Class MemberView extends View
{
    public static function getCV()
    {
        $filename = "assets/files/cv.pdf";
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));
        header('Accept-Ranges: bytes');
        @readfile($filename);
    }

    public static function home($user)
    {
        $array = array(
            'title'=> 'Accueil',
            'user'=> $user,
            'root'=> self::getRoot(),
        );
        return MemberView::renderView('member/home.twig', $array); 
    }

    public static function login()
    {
        $array = array(
            'title'=> 'S\'identifier',
            'root'=> self::getRoot(),
        );
        return MemberView::renderView('member/login.twig', $array); 
    }
    
    public static function administration($user)
    {
        $array = array(
            'title'=> 'Administration',
            'root'=> self::getRoot(),
            'user'=> $user,
        );
        return MemberView::renderView('member/administration.twig', $array); 
    }

    public static function signUp()
    {
        $array = array(
            'title'=> 'Devenir membre',
            'root'=> self::getRoot(),
        );
        return MemberView::renderView('member/signUp.twig', $array); 
    }

    public static function formEditPassword( $user)
    {
        $array = array(
            'title'=> 'Modifier Mot de passe',
            'root'=> self::getRoot(),
            'user'=> $user,
        );
        return MemberView::renderView('member/editPassword.twig', $array); 
    }
    public static function errorMessage($error, $array = null)
    {
        $message = "error";
       
        switch($error)
        {
            case "authFail":
                if(isset($array["login"]))
                {
                    $message = "L'utilisateur ".$array["login"]." n'a pas été trouvé.";
                }
                break;
            case "memberExists":
                if(isset($array["login"]))
                {
                    $message = "Le login ".$array["login"]." est déja utilisé,
                    veuillez en changer.";
                }
                break;    
            case "pushFail":
                    $message = 'Une erreur s\'est produit lors de 
                    l\'enregistrement en bade de donnée, veuillez réessayer.';
                break;
            case "wrongLoginForUser":
                    $message = 'Le login et l\'id ne correspondent pas.';
                break;
            
            case "editPasswordFail":
                    $message = 'La modification du mot de passe a échoué';
                break;
        }
        return $message;
    }

}