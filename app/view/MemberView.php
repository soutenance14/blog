<?php

Class MemberView
{

    public static function login()
    {
        return "login
        <form action ='auth' method ='post'><input name='login'><input name='password'><input type='submit' name ='submit' value='ok'>
        </form>";
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

    public static function formEditPassword( $token)
    {
        return "formEditPassword
        <form action ='editPassword' method ='post'><input name='oldPassword'><input name='newPassword'><input name='confirmNewPassword'>
        <input type='submit' name ='submit' value='ok'>
        <br> <input name ='token' value='".$token."'>
        </form>";
    }

    // public static function pushFail()
    // {
    //     return 'Le push a échoué';  
    // }
    
    public static function editPasswordFail()
    {
        return 'L\'edition  a échoué';  
    }
    
    // public static function deleteFail()
    // {
    //     return 'La suppression a échoué';  
    // }
    
}