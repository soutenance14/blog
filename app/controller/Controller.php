<?php



Class Controller
{
    public function auth($login, $password)
    {
        require  dirname(__DIR__) . '../model/MemberManager.php';
        $memberManager = new MemberManager();
        $member = $memberManager->auth($login, $password);
        if($member != null){
            //Use SESSION for save the member
            session_start();
            $_SESSION["user"] = $member;
            echo 'création session member + redirection home';
        }
        else{
            echo 'redirection login + mess error auth';
        }
    }
}