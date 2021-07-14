<?php


require dirname(__DIR__) . '../db/DatabaseConnexion.php';

Class MemberManager{

    public static function auth(String $login, String $password)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, login, password, type from MEMBER where login = :login and password = :password");
        $request->bindParam(':login', $login, \PDO::PARAM_STR);
        $request->bindParam(':password', $password, \PDO::PARAM_STR);
        $request->execute();
        $member = $request->fetch(\PDO::FETCH_ASSOC);
        return $member;
    }

    public static function editPassword(String $id, String $password)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "UPDATE MEMBER set password =:password where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->bindParam(':password', $password, \PDO::PARAM_STR);
        $request->execute();
        $member = $request->fetch(\PDO::FETCH_ASSOC);
        return $member;
    }


}