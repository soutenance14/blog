<?php


require dirname(__DIR__) . '../db/DatabaseConnexion.php';

Class CommentManager{
    
    public static function get(String $id)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, contenu, created_at, published, id_membre from COMMENT where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->execute();
        $post = $request->fetch(\PDO::FETCH_ASSOC);
        return $post;
    }

    public static function getAll()
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, contenu, published, created_at from COMMENT");
        $request->execute();
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }

    // if the app just show the published, this is useless
    // if the app show all comment, and just hide the content for not published comment
    // this is useful

    // public static function getAllPublished()
    // {
    //     $request = DatabaseConnexion::getPdo()->prepare(
    //         "SELECT id, contenu, published, created_at from COMMENT where published = 1");
    //     $request->execute();
    //     $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
    //     return $posts;
    // }

    public static function getAllNotPublished()
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "SELECT id, contenu, published, created_at from COMMENT where published = 0");
        $request->execute();
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }

    public static function push( $id_membre, $id_post, $contenu)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "INSERT INTO COMMENT (id_post, id_membre, contenu, published, created_at) values (:id_post, :id_membre, :contenu, 0, current_timestamp)");
            $request->bindParam(':id_post', $id_post, \PDO::PARAM_STR);
            $request->bindParam(':id_membre', $id_membre, \PDO::PARAM_STR);
            $request->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
            $affectedLines = $request->execute();
            return $affectedLines;
    }

    public static function setPublished($id, $published)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "UPDATE COMMENT set published = :published, created_at = current_timestamp where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $request->bindParam(':published', $published, \PDO::PARAM_STR);
            $affectedLines = $request->execute();
        return $affectedLines;
    }

    public static function delete( $id)
    {
        $request = DatabaseConnexion::getPdo()->prepare(
            "DELETE from COMMENT where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $affectedLines = $request->execute();
        return $affectedLines;
    }
}