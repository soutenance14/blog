<?php


require dirname(__DIR__) . '../db/DatabaseConnexion.php';

Class PostManager{
    
    public static function get(String $id)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, auteur, titre, chapo, contenu, created_at from POST where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->execute();
        $member = $request->fetch(\PDO::FETCH_ASSOC);
        return $member;
    }
}