<?php

Abstract Class Controller
{
    private static $root = null;
    
    public static function ifPDOExceptionView(\PDOException $e)
    {
        switch($e->getCode())
        {
            case '1049':
                return View::renderViewException(
                    $e, "Problème avec la base de données", 
                    "databaseError-bg","Connexion impossible à la base de données.");
                break;    
            case '42S22':
                return View::renderViewException(
                    $e, "Problème avec la base de données",
                     "databaseError-bg", "Impossible de récupérer les données d'une colonne 
                dans une table de la base de données.");
                break;    
            case '42S02':
                return View::renderViewException(
                    $e, "Problème avec la base de données", "databaseError-bg", 
                    "Impossible de se connecter à une table de la base de données.");
                break;    
            case '42000':
                return View::renderViewException(
                    $e, "Problème avec la base de données", "databaseError-bg", "Erreur de syntaxe SQL");
                break;
            case '23000':
                return View::renderViewException(
                    $e, "Problème avec la base de données", "databaseError-bg", "Problème de contrainte(s) de clé(s).");
                break;
            default:
                return View::renderViewException(
                    $e, "Problème avec la base de données", "databaseError-bg", "Un problème innatendue est arrivée en lien avec la base de données.");
        }
    }
    
    public static function ifAccessViolationExceptionView(AccessViolationException $e)
    {
        return View::renderViewException($e, "Problème de droit d'accées", "accessViolation-bg", false);
    }

    public static function permissionToken(String $permissionRequested, $user, $tokenSent)
    {
        if($user->getToken() != $tokenSent)
        {
            throw new AccessViolationException('Wrong token sent.', 96);
        }
        Controller::permission($permissionRequested, $user);
    } 

    public static function permission(String $permissionRequested, $user)
    {   
        switch($permissionRequested)
        {
            case USER_AUTHENTIFIED:
                if($user->getPermission() === USER_NOT_AUTHENTIFIED)
                {
                    throw new AccessViolationException('User not authentified.', 97);
                }
                break;
                
            case ADMIN:
                
                if($user->getPermission() === USER_AUTHENTIFIED 
                    ||$user->getPermission() === ADMIN) 
                {
                    if( $user->getPermission() != ADMIN)
                    {
                        throw new AccessViolationException('User is not admin.', 98);
                    }
                }
                else
                {
                    throw new AccessViolationException('User not authenfied.', 97);
                }
                break;
            default:
                throw new AccessViolationException('Unknown permission requested.', 100);
                break;
        }
    }

    public static function permissionThisIdMember( $user, $id_member_permission, $tokenSent)
    {
        require dirname(__DIR__) . "../exception/AccessViolationException.php";
        if($user->getPermission() != USER_NOT_AUTHENTIFIED && $user->getToken() === $tokenSent) 
        {
            if( ($user->getId() != $id_member_permission) && ($user->getPermission() != ADMIN)    )
            {
                throw new AccessViolationException('user is not the owner and not admin.', 101);
            }
        }
        else
        {
            throw new AccessViolationException('User not authenfied.', 97);
        }
    }

    public static function getRoot()
    {
        if(self::$root === null)
        {
            require dirname(__DIR__) . "../config/configRoot.php";
            self::$root = $root;
        }
        return self::$root;
    }
}
