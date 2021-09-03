<?php

Class MemberView extends View
{

    public static function home($user)
    {
        $array = array(
            'title'=> 'Accueil',
            'user'=> $user,
        );
        return MemberView::renderView('member/home.twig', $array); 
    }

    public static function login()
    {
        $array = array(
            'title'=> 'S\'identifier',
        );
        return MemberView::renderView('member/login.twig', $array); 
    }
    
    public static function signUp()
    {
        $array = array(
            'title'=> 'Devenir membre',
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
            'user'=> $user,
        );
        return MemberView::renderView('member/signUp.twig', $array); 
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