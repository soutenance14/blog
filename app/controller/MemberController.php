<?php

require  'Controller.php';
require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/MemberManager.php';

Abstract Class MemberController
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
            MemberController::ifPDOExceptionView($e);
        }
    }

    public static function editPassword($oldPassord, $newPassword)
    {
        try
        {
            //use js for check new password and confirmNewPassword
            $userSession = UserSession::getUser(); 
            MemberController::permission(USER_AUTHENTIFIED, $userSession); 

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
        catch (\PDOException $e)
        {
            MemberController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            MemberController::ifAccessViolationExceptionView($e);
        }
    }

    public static function disconnect()
    {
        UserSession::disconnect();
        echo 'disconnect';
    }

    // view if PDO exception
    private static function ifPDOExceptionView(\PDOException $e)
    {
        // Class is static, no instance, heritage is not possible
        // no parent::ifPDOExceptionView($e);
        return Controller::ifPDOExceptionView($e);
    }

    // view if exception AccessViolationException
    private static function ifAccessViolationExceptionView(AccessViolationException $e)
    {
        // Class is static, no instance, heritage is not possible
        // no parent::ifPDOExceptionView($e);
        return Controller::ifAccessViolationExceptionView($e);
    }

    private static function permission(String $permission, $user)
    {
        Controller::permission($permission, $user);
    }
}