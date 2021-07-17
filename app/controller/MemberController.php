<?php

define('USER_AUTHENTIFIED', 0);
define('ADMIN', 1);

Abstract Class MemberController
{
    //FORM
    public static function login()
    {
        echo "login";
        echo "<form action ='auth' method ='post'><input name='login'><input name='password'><input type='submit' name ='submi' value='ok'></form>";
    }
    
    public static function formEditPassword()
    {
        echo "formEditPassword";
        echo "<form action ='editPassword' method ='post'><input name='oldPassword'><input name='newPassword'><input name='confirmNewPassword'><input type='submit' name ='submit' value='ok'></form>";
    }

    // NOT FORM
    public static function auth($login, $password, $blogSession)
    {
        try
        {
            $member = MemberManager::auth($login, $password);
            if($member != null)
            {
                $blogSession->setUser($member);
                echo'member model' , var_dump($member);
                echo '<br> session user' , var_dump($blogSession->getUser());
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

    public static function editPassword($oldPassord, $newPassword, $userSession)
    {
        try
        {
            //use js for check new password and confirmNewPassword
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

    public static function disconnect($blogSession)
    {
        $blogSession->disconnect();
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