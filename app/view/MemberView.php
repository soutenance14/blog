<?php

Class MemberView extends View
{
    public static function cv()
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
    
    public static function authFail($login)
    {
        $array = array(
            
            'title'=> 'Echec lors de l\'authentification.',
            'message'=> "L'utilisateur ".$login." n'a pas été trouvé.",
            'root'=>self::getRoot(),
        ); 
        return MemberView::renderViewMessage($array);
    }

    public static function memberExist($login)
    {
        $array = array(
            
            'title'=> 'Echec de l\'inscription.',
            'message'=> "Le login ".$login." est déja utilisé,
            veuillez en changer.",
            'root'=>self::getRoot(),
        ); 
        return MemberView::renderViewMessage($array);
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
    
    public static function pushFail()
    {
        $array = array(
            
            'title'=> 'Echec de l\'inscription.',
            'message'=> 'Une erreur s\'est produit lors de l\'enregistrement en bade de donnée, veuillez réessayer.',
            'root'=>self::getRoot(),
        ); 
        return MemberView::renderViewMessage($array);
    }

    public static function deleteFail($login, $id)
    {
         $array = array(
            
            'title'=> 'Echec de la suppression.',
            'message'=> 'La suppression du compte de '.$login.',
            id: '.$id.' a échoué',
            'root'=>self::getRoot(),
        ); 
        return MemberView::renderViewMessage($array);
    }
    
    public static function wrongLoginForUser($login, $id)
    {
        $array = array(
            
            'title'=> 'Erreur de login.',
            'message'=> 'Le login et l\'id ne correspondent pas.',
            'root'=>self::getRoot(),
        ); 
        return MemberView::renderViewMessage($array); 
    }

    public static function editPasswordFail()
    {
        $array = array(
            
            'title'=> 'Erreur lors de la modification',
            'message'=> 'La modification du mot de passe a échoué',
            'root'=>self::getRoot(),
        ); 
        return MemberView::renderViewMessage($array); 
    }
    
}