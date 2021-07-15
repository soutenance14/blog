<?php

// define('USER_NO_AUTHENTIFIED', null);
define('USER_AUTHENTIFIED', 0);
define('ADMIN', 1);
define('ADMIN_OR_THIS_USER_AUTHENTIFIED', 2);

Abstract Class Controller
{
    public static function viewIfPDOException(\PDOException $e)
    {
        switch($e->getCode())
        {
            case '1049':
                echo 'view pb avec la db: connexion impossible à la db.' , $e->getCode(), $e->getMessage();
                break;    
            case '42S22':
                echo 'view pb avec la db: impossible de récupérer les données d\'une colonne.' , $e->getCode(), $e->getMessage();
                break;    
            case '42S02':
                echo 'view pb avec la db: impossible de se connecter à une table.' , $e->getCode(), $e->getMessage();
                break;    
            case '42000':
                echo 'view pb avec la db: erreur de syntaxe.' , $e->getCode(), $e->getMessage();
                break;
            default:
                echo 'view pb avec la db: une erreur inatendue est arrivé avec la db.';
                throw new \PDOException($e->getMessage(), (int)$e->getCode());  
        }
    } 

    public static function permission(String $permission, $user, $id_member_permission)
    {
        require dirname(__DIR__) . "../exception/AccessViolationException.php";
        switch($permission)
        {
            case USER_AUTHENTIFIED:
                if(!isset($user['type']))
                {
                    throw new AccessViolationException('User not authenfied.', 97);
                }
                break;
                
            case ADMIN:
                if(!isset($user['type']) || $user['type'] !== 'admin')
                {
                    throw new AccessViolationException('User not authenfied, or not admin.', 98);
                }
                break;
            case ADMIN_OR_THIS_USER_AUTHENTIFIED:
                // if( (!isset($user['id'])) || (  ($user['id'] != $id_member_permission) && ($user['type'] !== 'admin')   )      )
                // {
                //     throw new AccessViolationException('User not authenfied, not have permission, or not admin.', 99);
                // }
                if(isset($user['id'])) 
                {
                    if( ($user['id'] != $id_member_permission) && ($user['type'] != 'admin')    )
                    {
                        throw new AccessViolationException('user is not the owner  and not admin.', 99);
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
}
