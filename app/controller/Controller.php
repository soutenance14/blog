<?php

require  dirname(__DIR__) . '../model/MemberManager.php';

Class Controller
{
    public function auth($login, $password)
    {
        $memberManager = new MemberManager();
        $member = $memberManager->auth($login, $password);
        if($member != null){
            session_start();
            $_SESSION["user"] = $member;
            echo 'création session member + redirection home';
        }
        else{
            echo 'redirection login + mess error auth';
        }
    }
}