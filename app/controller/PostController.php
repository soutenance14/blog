<?php

require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/PostManager.php';
Class PostController
{
    public static function get(String $id)
    {
        $post = PostManager::get($id);
        if($post != null)
        {
            echo 'récupération de post '. $post['id'];
        }
        else
        {
            echo 'redirection ce post n\'existe pas.';
        }
    }

    public static function getAll()
    {
        $posts = PostManager::getAll();
        if($posts != null)
        {
            echo 'récupération de posts '. $posts[0]['id'];
        }
        else
        {
            echo 'redirection Il n\'ya aucun post.';
        }
    }

    public static function push( $auteur, $titre, $chapo, $contenu)
    {
        $userSession = UserSession::getUser(); 
        if(isset($userSession['type']) && $userSession['type'] === 'admin')
        {
            $affectedLines = PostManager::push( $auteur, $titre, $chapo, $contenu);
            if($affectedLines != null)
            {
                echo 'redirection push post success.';
            }
            else
            {
                echo 'redirection push post failed.';
            }
        }
        else
        {
            echo 'redirection droits insuffisants';
        }
    }

    public static function edit($id, $auteur, $titre, $chapo, $contenu)
    {
        $userSession = UserSession::getUser(); 
        if(isset($userSession['type']) && $userSession['type'] === 'admin')
        {
            $affectedLines = PostManager::edit($id, $auteur, $titre, $chapo, $contenu);
            if($affectedLines != null)
            {
                echo 'redirection edit post success.';
            }
            else
            {
                echo 'redirection edit post failed.';
            }
        }
        else
        {
            echo 'redirection droits insuffisants';
        }
    }

    public static function delete( $id)
    {
        $userSession = UserSession::getUser(); 
        if(isset($userSession['type']) && $userSession['type'] === 'admin')
        {
            $affectedLines = PostManager::delete( $id);
            if($affectedLines != null)
            {
                echo 'redirection delete post success.';
            }
            else
            {
                echo 'redirection delete post failed.';
            }
        }
        else
        {
            echo 'redirection droits insuffisants';
        }
    }

}