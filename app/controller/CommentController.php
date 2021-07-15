<?php

require  'Controller.php';
require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/CommentManager.php';

Abstract Class CommentController
{
    public static function get(String $id)
    {
        try
        {
            $comment = CommentManager::get($id);
            if($comment != null)
            {
                echo 'récupération de comment '. $comment['id'];
            }
            else
            {
                echo 'redirection ce comment n\'existe pas.';
            }
        }
        catch (\PDOException $e)
        {
            CommentController::viewIfPDOException($e);
        }
    }

    public static function getAll()
    {
        try 
        {
            $comments = CommentManager::getAll();
            if($comments != null)
            {
                echo 'récupération de comments '. $comments[0]['id'];
            }
            else
            {
                echo 'redirection Il n\'ya aucun comment.';
            }
        } 
        catch (\PDOException $e)
        {
            CommentController::viewIfPDOException($e);
        }
    }

    public static function push( $id_post, $contenu)
    {
        try{
            $userSession = UserSession::getUser(); 
            if(isset($userSession['type'])  )
            {
                $affectedLines = CommentManager::push( $userSession['id'], $id_post, $contenu);
                if($affectedLines != null)
                {
                    echo 'redirection push comment success.';
                }
                else
                {
                    echo 'redirection push comment failed.';
                }
            }
            else
            {
                echo 'redirection droits insuffisants';
            }
        }
        catch (\PDOException $e)
        {
            CommentController::viewIfPDOException($e);
        }
    }

    public static function setPublished($id, $published)
    {
        if( $published === '0' || $published === '1')
        {
            try
            {
                $userSession = UserSession::getUser(); 
                if(isset($userSession['type']) && $userSession['type'] === 'admin')
                {
                    $affectedLines = CommentManager::setPublished($id, $published);
                    if($affectedLines != null)
                    {
                        echo 'redirection setPublished comment success.';
                    }
                    else
                    {
                        echo 'redirection setPublished comment failed.';
                    }
                }
                else
                {
                    echo 'redirection droits insuffisants';
                }
            }
            catch (\PDOException $e)
            {
                CommentController::viewIfPDOException($e);
            }
        }
        else
        {
            echo 'mauvaise valeur donnée.';
        }
    }

    public static function delete( $id)
    {
        try
        {
            $userSession = UserSession::getUser();
            // if user is admin, delete is possible
            if(isset($userSession['type']) && $userSession['type'] === 'admin')
            {
                $affectedLines = CommentManager::delete( $id);
                if($affectedLines !== null)
                {
                    echo 'redirection delete comment success.';
                    var_dump($affectedLines);
                }
                else
                {
                    echo 'redirection delete comment failed.';
                }
            } 
            elseif(isset($userSession['type']))
            {
                $comment = CommentManager::get($id);
                if(isset($comment['id_membre']) && $comment['id_membre'] === $userSession['id'] )
                {
                    // if user is the author's comment delete is possible
                    $affectedLines = CommentManager::delete( $id);
                    if($affectedLines != null)
                    {
                        echo 'redirection delete comment success.';
                    }
                    else
                    {
                        echo 'redirection delete comment failed.';
                    }
                }
                else
                {
                    echo 'Ce commentaire n\'existe pas, ou n\'est pas le votre';
                }
            }
            else
            {
                echo 'redirection droits insuffisants';
            }
        }
        catch (\PDOException $e)
        {
            CommentController::viewIfPDOException($e);
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