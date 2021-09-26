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

    public static function home()
    {
        $array = array('title'=> 'Accueil',);
        return MemberView::renderView('member/home.twig', $array); 
    }

    public static function login()
    {
        $array = array('title'=> 'S\'identifier',);
        return MemberView::renderView('member/login.twig', $array); 
    }
    
    public static function administration()
    {
        $array = array('title'=> 'Administration');
        return MemberView::renderView('member/administration.twig', $array); 
    }

    public static function signUp()
    {
        $array = array('title'=> 'Devenir membre' );
        return MemberView::renderView('member/signUp.twig', $array); 
    }

    public static function formEditPassword()
    {
        $array = array('title'=> 'Modifier Mot de passe' );
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
                    $message = "L'utilisateur \"".$array["login"]."\" n'a pas été trouvé.";
                }
                break;
            case "wrongPasswordAuth":
                if(isset($array["login"]))
                {
                    $message = "Mauvais mot de passe pour \"".$array["login"]."\"";
                }
                break;
            case "memberExists":
                if(isset($array["login"]))
                {
                    $message = "Le login \"".$array["login"]."\" est déja utilisé,
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