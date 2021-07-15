<?php

require  'Controller.php';
require  dirname(__DIR__) . '../UserSession.php';
require  dirname(__DIR__) . '../model/PostManager.php';

Abstract Class PostController
{
    // FORM WITHOUT MODELS
    public static function formPushPost()
    {
        try
        {
            $userSession = UserSession::getUser(); 
            PostController::permission(USER_AUTHENTIFIED, $userSession);
            
            echo "formPushPost";
            echo "<form action ='pushPost' method ='post'><input name='auteur'><input name='titre'><input name='chapo'><input name='contenu'><input type='submit' name ='submit' value='ok'></form>";
        }
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
        }
    }
    
    // WITH MODELS
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
            PostController::ifPDOExceptionView($e);
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
            PostController::ifPDOExceptionView($e);
        }
    }

    public static function push( $auteur, $titre, $chapo, $contenu)
    {
        try{
            $userSession = UserSession::getUser(); 
            
            PostController::permission(ADMIN, $userSession); 
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
        catch (\PDOException $e)
        {
            PostController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
        }
    }

    public static function edit($id, $auteur, $titre, $chapo, $contenu)
    {
        try
        {
            $userSession = UserSession::getUser(); 
            
            PostController::permission(ADMIN, $userSession); 
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
        catch (\PDOException $e)
        {
            PostController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
        }
    }

    public static function delete( $id)
    {
        try
        {
            $userSession = UserSession::getUser(); 
            PostController::permission(ADMIN, $userSession); 

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
        catch (\PDOException $e)
        {
            PostController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
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
}