<?php

require dirname(__DIR__) . '../../vendor/autoload.php';
Class MemberManager extends Manager{

    public static function auth($memberEntity)
    {
        $login = $memberEntity->getLogin();
        $password = $memberEntity->getPassword();

        $request = self::getPdo()->prepare(
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
        $request = self::getPdo()->prepare(
            "SELECT login from MEMBER where login = :login");
        $request->bindParam(':login', $login, \PDO::PARAM_STR);
        $request->execute();
        $login = $request->fetch(\PDO::FETCH_ASSOC)['login'];
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

        $request = self::getPdo()->prepare(
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

        $request = self::getPdo()->prepare(
            "UPDATE MEMBER set password =:password where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->bindParam(':password', $password, \PDO::PARAM_STR);
        $request->execute();
        $member = $request->fetch(\PDO::FETCH_ASSOC);
        return $member;
    }

    public static function delete( $memberEntity)
    {
        //le login est demandé aussi par sécurité, si l'admin
        // veut supprimer l'utilisateur, il a donc l'obligation d'entrer son login
        $id = $memberEntity->getId();
        $login = $memberEntity->getLogin();
        $request = self::getPdo()->prepare(
            "DELETE from MEMBER where id = :id and login = :login and type <> 'admin'");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $request->bindParam(':login', $login, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
        return $requestSuccess;
    }

    public static function memberNotExist($id)
    {
        $request = self::getPdo()->prepare(
            "SELECT id from MEMBER where id = :id ");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->execute();
        $id = $request->fetch(\PDO::FETCH_ASSOC)['id'];
        $memberNotExist = false;
        
        if($id == null)
        {
            $memberNotExist = true;
        }

        return $memberNotExist;
    }
}