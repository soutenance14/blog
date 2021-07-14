<?php


require dirname(__DIR__) . '../db/DatabaseConnexion.php';

Class MemberManager{
    
    private $pdo;

    public function __construct()
    {
        if(\DatabaseConnexion::getPdo() == null)
        {
            \DatabaseConnexion::createPdo();
        }
        $this->pdo = \DatabaseConnexion::getPdo();
        
    }

    public function auth(String $login, String $password){
        $request = $this->pdo->prepare(
            "SELECT id, login, password, type from MEMBER where login = :login and password = :password");
        $request->bindParam(':login', $login, \PDO::PARAM_STR);
        $request->bindParam(':password', $password, \PDO::PARAM_STR);
        $request->execute();
        $member = $request->fetch(\PDO::FETCH_ASSOC);
        return $member;
    }
}