<?php
namespace App\Model;

abstract Class Manager
{    
    private static $pdo;

    public static function createPdo()
    {
        //get config for database connexion
        require dirname(__DIR__) . "../config/configDBLocal.php";  
        // more explain about dsn and oprions here -> https://phpdelusions.net/pdo#dsn 

        $dsn = "mysql:host=".HOST.";dbname=".DB_NAME.";port=".PORT.";charset=".CHARSET;

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try 
        {
            self::$pdo = new \PDO($dsn, USER, PASS, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getPdo()
    {
        if(self::$pdo === null)
        {
            self::createPdo();
        }
        return self::$pdo;
    }
}