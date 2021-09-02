<?php

require_once dirname(__DIR__) . '../db/DatabaseConnexion.php';

Class CommentManager{
    
    // i think these 2 functions are useless,, but for the moment,
    // no deleted, waiting for see later

    public static function get(String $id)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, id_membre, id_post from COMMENT where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->execute();
        $post = $request->fetch(\PDO::FETCH_ASSOC);
        return $post;
    }

    // public static function getAll()
    // {
    //     $request = DatabaseConnexion::getPdo()->prepare(
    //         "SELECT id, contenu, published, created_at from COMMENT");
    //     $request->execute();
    //     $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
    //     return $posts;
    // }

    public static function getAllPublished(String $id_post)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT comment.id as id, contenu, published, created_at, id_post, id_membre,
            login , member.id as memberId
     from COMMENT
    inner join member
    on member.id = id_membre
    where id_post = :id_post and published = 1");
            $request->bindParam(':id_post', $id_post, \PDO::PARAM_STR);
        $request->execute();
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
        
    }
    
    public static function getAllNotPublished(String $id_post)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT comment.id as id, contenu, published, created_at, id_post, id_membre,
                    login, member.id as memberId
             from COMMENT
            inner join member
            on member.id = id_membre
            where id_post = :id_post and published = 0");
        $request->bindParam(':id_post', $id_post, \PDO::PARAM_STR);
        $request->execute();
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }

    public static function pushNotPublished( $commentEntity)
    {
        $id_post = $commentEntity->getIdPost();
        $id_membre = $commentEntity->getIdMembre();
        $contenu = $commentEntity->getContenu();

        $request = DatabaseConnexion::getPdo()->prepare(
            "INSERT INTO COMMENT (id_post, id_membre, contenu, published, created_at) values (:id_post, :id_membre, :contenu, 0, current_timestamp)");
            $request->bindParam(':id_post', $id_post, \PDO::PARAM_STR);
            $request->bindParam(':id_membre', $id_membre, \PDO::PARAM_STR);
            $request->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
            return $requestSuccess;
    }
    
    public static function pushPublished( $commentEntity)
    {

        $id_post = $commentEntity->getIdPost();
        $id_membre = $commentEntity->getIdMembre();
        $contenu = $commentEntity->getContenu();

        $request = DatabaseConnexion::getPdo()->prepare(
            "INSERT INTO COMMENT (id_post, id_membre, contenu, published, created_at) values (:id_post, :id_membre, :contenu, 1, current_timestamp)");
            $request->bindParam(':id_post', $id_post, \PDO::PARAM_STR);
            $request->bindParam(':id_membre', $id_membre, \PDO::PARAM_STR);
            $request->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
            return $requestSuccess;
    }

    public static function setPublished($commentEntity)
    {
        $id = $commentEntity->getId();
        $published = $commentEntity->getPublished();
        $request = DatabaseConnexion::getPdo()->prepare(
            "UPDATE COMMENT set published = :published, created_at = current_timestamp where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $request->bindParam(':published', $published, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
        return $requestSuccess;
    }

    public static function delete( $id)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "DELETE from COMMENT where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
        return $requestSuccess;
    }
}