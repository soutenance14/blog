<?php

require  'Controller.php';
require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/MemberManager.php';

Abstract Class MemberController extends Controller
{
    public static function auth($login, $password)
    {
        try
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
        catch (\PDOException $e)
        {
            MemberController::viewIfPDOException($e);
        }
    }

    public static function editPassword($oldPassord, $newPassword)
    {
        try
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
        catch (\PDOException $e)
        {
            MemberController::viewIfPDOException($e);
        }
    }

    // view if exception
    public static function viewIfPDOException(\PDOException $e)
    {
        // Class is static, no instance, heritage is not possible
        // no parent::viewIfPDOException($e);
        return Controller::viewIfPDOException($e);
    } 
}