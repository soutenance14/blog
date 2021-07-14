<?php

Class Manager{
    
    public $pdo;
    
    public function __construct()
    {
        //get config for database connexion
        require dirname(__DIR__) . "../configDB.php";  
        // more explain about dsn and oprions here -> https://phpdelusions.net/pdo#dsn 

        $dsn = "mysql:host=$HOST;dbname=$DB_NAME;port=$PORT;charset=$CHARSET";

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try 
        {
            $this->pdo = new \PDO($dsn, $USER, $PASS, $options);
            
            echo "connexion to database successfull\n****\n\n";
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}