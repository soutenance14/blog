<?php

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
}