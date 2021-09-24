<?php
namespace App\Model;

require dirname(__DIR__) . '../../vendor/autoload.php';

Class PostManager extends Manager{
    
    public static function get(String $slug)
    {
        $request = self::getPdo()->prepare(
            "SELECT id, auteur, titre, slug, chapo, contenu, created_at from POST where slug = :slug");
        $request->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $request->execute();
        $post = $request->fetch(\PDO::FETCH_ASSOC);
        return $post;
    }
    
    public static function getFromId(String $id)
    {
        $request = self::getPdo()->prepare(
            "SELECT id, auteur, titre, slug, chapo, contenu, created_at from POST where id = :id");
        $request->bindParam(':id', $id, \PDO::PARAM_STR);
        $request->execute();
        $post = $request->fetch(\PDO::FETCH_ASSOC);
        return $post;
    }


    public static function getAll()
    {
        $request = self::getPdo()->prepare(
            "SELECT id, auteur, titre, slug, chapo, contenu, created_at from POST
            ORDER BY created_at DESC
            ");
        $request->execute();
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }

    public static function push( $postEntity)
    {
        $auteur = $postEntity->getAuteur();
        $titre = $postEntity->getTitre();
        $slug = $postEntity->getSlug();
        $chapo = $postEntity->getChapo();
        $contenu = $postEntity->getContenu();

        $request = self::getPdo()->prepare(
            "INSERT INTO POST (auteur, titre, slug, chapo, contenu, created_at) values (:auteur, :titre, :slug, :chapo, :contenu, current_timestamp)");
            $request->bindParam(':auteur', $auteur, \PDO::PARAM_STR);
            $request->bindParam(':titre', $titre, \PDO::PARAM_STR);
            $request->bindParam(':slug', $slug, \PDO::PARAM_STR);
            $request->bindParam(':chapo', $chapo, \PDO::PARAM_STR);
            $request->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
            return $requestSuccess;
    }

    public static function edit($postEntity)
    {
        $id = $postEntity->getId();
        $auteur = $postEntity->getAuteur();
        $titre = $postEntity->getTitre();
        $slug = $postEntity->getSlug();
        $chapo = $postEntity->getChapo();
        $contenu = $postEntity->getContenu();

        $request = self::getPdo()->prepare(
            "UPDATE POST set auteur = :auteur, titre = :titre, slug = :slug, chapo = :chapo, contenu = :contenu, created_at = current_timestamp where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            $request->bindParam(':auteur', $auteur, \PDO::PARAM_STR);
            $request->bindParam(':titre', $titre, \PDO::PARAM_STR);
            $request->bindParam(':slug', $slug, \PDO::PARAM_STR);
            $request->bindParam(':chapo', $chapo, \PDO::PARAM_STR);
            $request->bindParam(':contenu', $contenu, \PDO::PARAM_STR);
            $requestSuccess = $request->execute();
        return $requestSuccess;
    }

    public static function delete( $id)
    {
        $request = self::getPdo()->prepare(
            "DELETE from POST where id = :id");
            $request->bindParam(':id', $id, \PDO::PARAM_STR);
            echo 'le ID : '.$id;
            $requestSuccess = $request->execute();
        return $requestSuccess;
    }
}