<?php

require  'Controller.php';
require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/PostManager.php';

Abstract Class PostController
{
    public static function get(String $id)
    {
        try
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
        catch (\PDOException $e)
        {
            PostController::viewIfPDOException($e);
        }
    }

    public static function getAll()
    {
        try 
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
        catch (\PDOException $e)
        {
            PostController::viewIfPDOException($e);
        }
    }

    public static function push( $auteur, $titre, $chapo, $contenu)
    {
        try{
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
        catch (\PDOException $e)
        {
            PostController::viewIfPDOException($e);
        }
    }

    public static function edit($id, $auteur, $titre, $chapo, $contenu)
    {
        try
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
        catch (\PDOException $e)
        {
            PostController::viewIfPDOException($e);
        }
    }

    public static function delete( $id)
    {
        try
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
        catch (\PDOException $e)
        {
            PostController::viewIfPDOException($e);
        }
    }

    // view if exception
    private static function viewIfPDOException(\PDOException $e)
    {
        // Class is static, no instance, heritage is not possible
        // no parent::viewIfPDOException($e);
        return Controller::viewIfPDOException($e);
    } 

}