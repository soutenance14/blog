<?php

require dirname(__DIR__) . '../db/DatabaseConnexion.php';

Class MemberManager{

    public static function auth($memberEntity)
    {
        $login = $memberEntity->getLogin();
        $password = $memberEntity->getPassword();

        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, login, password, type from MEMBER where login = :login and password = :password");
        $request->bindParam(':login', $login, \PDO::PARAM_STR);
        $request->bindParam(':password', $password, \PDO::PARAM_STR);
        $request->execute();
        $member = $request->fetch(\PDO::FETCH_ASSOC);
        return $member;
    }
    
    public static function loginNotExist($memberEntity)
    {
        $login = $memberEntity->getLogin();
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT login from MEMBER where login = :login");
        $request->bindParam(':login', $login, \PDO::PARAM_STR);
        $request->execute();
        $login = $request->fetch(\PDO::FETCH_ASSOC)['login'];
        var_dump($login);
        $loginNotExist = false;
        if( $login === null )
        {
            $loginNotExist = true;
        }
        return $loginNotExist;
    }

    public static function push( $memberEntity)
    {
        $login = $memberEntity->getLogin();
        $password = $memberEntity->getPassword();

        $request = DatabaseConnexion::getPdo()->prepare(
            "INSERT INTO MEMBER (login, password, type) values (:login, :password, 'subscriber')");
            $request->bindParam(':login', $login, \PDO::PARAM_STR);
            $request->bindParam(':password', $password, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
            return $requestSuccess;
    }

    public static function editPassword($memberEntity)
    {

        $id = $memberEntity->getId();
        $password = $memberEntity->getPassword();

        $request = DatabaseConnexion::getPdo()->prepare(
            "UPDATE MEMBER set password =:password where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->bindParam(':password', $password, \PDO::PARAM_STR);
        $request->execute();
        $member = $request->fetch(\PDO::FETCH_ASSOC);
        return $member;
    }
}