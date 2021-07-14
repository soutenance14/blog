<?php

require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/MemberManager.php';

Class MemberController
{

    // function __construct()
    // {
    //     require  dirname(__DIR__) . '../model/MemberManager.php';
    //     $this->memberManager = new MemberManager();
    // }

    public static function auth($login, $password)
    {
        $member = MemberManager::auth($login, $password);
        if($member != null)
        {
            UserSession::setUser($member);
            var_dump($member);
            var_dump(UserSession::getUser());
        }
        else
        {
            echo 'redirection login + mess error auth';
        }
    }

    public static function editPassword($oldPassord, $newPassword)
    {
        //use js for check new password and confirmNewPassword
        $userSession = UserSession::getUser(); 
        if($userSession === USER_NO_AUTHENTIFIED)
        {
            echo 'redirection utilisateur non connecté';
            var_dump ($userSession);
        }
        else
        {
            if( $userSession['password'] === $oldPassord)
            {
                //user can only change his password, not for another member
                MemberManager::editPassword($userSession['id'], $newPassword);
                echo 'oui changement';
            }
            else
            {
                echo 'redirection mauvais old password';
            }
        }
    }
}