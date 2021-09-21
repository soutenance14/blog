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
    
    public static function administration()
    {
        $array = array(
            'title'=> 'Administration',
            'root'=> self::getRoot(),
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
    
    public static function memberExist($login)
    {
        return MemberView::renderViewMessage("Le login ".$login." est déja utilisé,
         veuillez en changer.");
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
        return MemberView::renderViewMessage('Le push a échoué');  
    }

    public static function deleteFail($login, $id)
    {
        return MemberView::renderViewMessage('La suppression du compte de '.$login.',
         id: ".$id." a échoué');  
    }
    
    public static function wrongLoginForUser($login, $id)
    {
        return MemberView::renderViewMessage('Le login et l\'id ne correspondent pas.');  
    }

    public static function editPasswordFail()
    {
        return MemberView::renderViewMessage('L\'edition  a échoué');  
    }
    
}