<?php

require  'Controller.php';
require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/CommentManager.php';
define('NO_NEED_USER_ID', null);

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
        try
        {
            $userSession = UserSession::getUser();
            CommentController::permission(USER_AUTHENTIFIED, $userSession, NO_NEED_USER_ID); 
            
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
        catch (\PDOException $e)
        {
            CommentController::viewIfPDOException($e);
        }
        catch (AccessViolationException $e)
        {
            echo $e->getMessage() , $e->getCode();
        }
    }

    public static function setPublished($id, $published)
    {
        if( $published === '0' || $published === '1')
        {
            try
            {
                $userSession = UserSession::getUser();
                CommentController::permission(ADMIN, $userSession, NO_NEED_USER_ID);
                
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
            catch (\PDOException $e)
            {
                CommentController::viewIfPDOException($e);
            }
            catch (AccessViolationException $e)
            {
                echo $e->getMessage() , $e->getCode();
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
            $comment = CommentManager::get($id);
            if($comment != null)
            {
                CommentController::permission(ADMIN_OR_THIS_USER_AUTHENTIFIED, $userSession, $comment['id_membre']);
                
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
            else
            {
                echo 'Ce commentaire n\'existe pas.';
            }
        }
        catch (\PDOException $e)
        {
            CommentController::viewIfPDOException($e);
        }
        catch (AccessViolationException $e)
        {
            echo $e->getMessage() , $e->getCode();
        }
    }

    // view if exception
    private static function viewIfPDOException(\PDOException $e)
    {
        // Class is static, no instance, heritage is not possible
        // no parent::viewIfPDOException($e);
        return Controller::viewIfPDOException($e);
    }

    private static function permission(String $permission, $user, $id_member_permission)
    {
        Controller::permission($permission, $user, $id_member_permission);
    }
}