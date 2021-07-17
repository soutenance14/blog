<?php

require dirname(__DIR__) . '../db/DatabaseConnexion.php';

Class PostManager{
    
    public static function get(String $id)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, auteur, titre, chapo, contenu, created_at from POST where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->execute();
        $post = $request->fetch(\PDO::FETCH_ASSOC);
        return $post;
    }

    public static function getAll()
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, auteur, titre, chapo, contenu, created_at from POST");
        $request->execute();
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }

    public static function push( $auteur, $titre, $chapo, $contenu)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "INSERT INTO POST (auteur, titre, chapo, contenu, created_at) values (:auteur, :titre, :chapo, :contenu, current_timestamp)");
            $request->bindParam(':auteur', $auteur, \PDO::PARAM_STR);
            $request->bindParam(':titre', $titre, \PDO::PARAM_STR);
            $request->bindParam(':chapo', $chapo, \PDO::PARAM_STR);
            $request->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
            $affectedLines = $request->execute();
            return $affectedLines;
    }

    public static function edit($id, $auteur, $titre, $chapo, $contenu)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "UPDATE POST set auteur = :auteur, titre = :titre, chapo = :chapo, contenu = :contenu, created_at = current_timestamp where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $request->bindParam(':auteur', $auteur, \PDO::PARAM_STR);
            $request->bindParam(':titre', $titre, \PDO::PARAM_STR);
            $request->bindParam(':chapo', $chapo, \PDO::PARAM_STR);
            $request->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
            $affectedLines = $request->execute();
        return $affectedLines;
    }

    public static function delete( $id)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "DELETE from POST where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $affectedLines = $request->execute();
        return $affectedLines;
    }
}