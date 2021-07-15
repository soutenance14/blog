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
            CommentController::ifPDOExceptionView($e);
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
            CommentController::ifPDOExceptionView($e);
        }
    }

    public static function push( $id_post, $contenu)
    {
        try
        {
            $userSession = UserSession::getUser();
            CommentController::permission(USER_AUTHENTIFIED, $userSession); 
            
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
            CommentController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            CommentController::ifAccessViolationExceptionView($e);
        }
    }

    public static function setPublished($id, $published)
    {
        if( $published === '0' || $published === '1')
        {
            try
            {
                $userSession = UserSession::getUser();
                CommentController::permission(ADMIN, $userSession);
                
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
                CommentController::ifPDOExceptionView($e);
            }
            catch (AccessViolationException $e)
            {
                CommentController::ifAccessViolationExceptionView($e);
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
                CommentController::permissionThisIdMember( $userSession, $comment['id_membre']);
                
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
            CommentController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            CommentController::ifAccessViolationExceptionView($e);
        }
    }

    // view if PDO exception
    private static function ifPDOExceptionView(\PDOException $e)
    {
        // Class is static, no instance, heritage is not possible
        // no parent::ifPDOExceptionView($e);
        return Controller::ifPDOExceptionView($e);
    }

    // view if exception AccessViolationException
    private static function ifAccessViolationExceptionView(AccessViolationException $e)
    {
        // Class is static, no instance, heritage is not possible
        // no parent::ifPDOExceptionView($e);
        return Controller::ifAccessViolationExceptionView($e);
    }

    private static function permission(String $permission, $user)
    {
        Controller::permission($permission, $user);
    }
    
    private static function permissionThisIdMember( $user, $id_member_permission)
    {
        require dirname(__DIR__) . "../exception/AccessViolationException.php";
        if(isset($user['id'])) 
        {
            if( ($user['id'] != $id_member_permission) && ($user['type'] != 'admin')    )
            {
                throw new AccessViolationException('user is not the owner  and not admin.', 99);
            }
        }
        else
        {
            throw new AccessViolationException('User not authenfied.', 97);
        }
    }

}