<?php

// require_once dirname(__DIR__) . "../config/constant.php";

Abstract Class Controller
{
    public static function ifPDOExceptionView(\PDOException $e)
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
            case '23000':
                //can not add or update a child, foreign constraitn failed
                echo 'view pb l\'élement recherché n\'existe pas dans la db.' , $e->getCode(), $e->getMessage();
                break;

            default:
                echo 'view pb avec la db: une erreur inatendue est arrivé avec la db.' , $e->getCode(), $e->getMessage();
                // throw new \PDOException($e->getMessage(), (int)$e->getCode());  
        }
    }
    
    public static function ifAccessViolationExceptionView(AccessViolationException $e)
    {
        echo 'view pb access violation: ', $e->getMessage(), $e->getCode();
    }

    public static function permission(String $permission, $user)
    {
        // require dirname(__DIR__) . "../exception/AccessViolationException.php";
        switch($permission)
        {
            case USER_AUTHENTIFIED:
                if(!isset($user['type']))
                {
                    throw new AccessViolationException('User not authenfied.', 97);
                }
                break;
                
            case ADMIN:
                if(isset($user['type']) )
                {
                    if( $user['type'] !== 'admin')
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
}
