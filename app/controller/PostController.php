<?php

define('USER_AUTHENTIFIED', 0);
define('ADMIN', 1);

Abstract Class PostController
{
    // FORM
    public static function formPushPost($userSession)
    {
        try
        {
            PostController::permission(USER_AUTHENTIFIED, $userSession);
            
            echo "formPushPost";
            echo "<form action ='pushPost' method ='post'><input name='auteur'><input name='titre'><input name='chapo'><input name='contenu'><input type='submit' name ='submit' value='ok'></form>";
        }
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
        }
    }
    
    public static function formEditPost(String $id, $userSession)
    {
        try
        {
            PostController::permission(USER_AUTHENTIFIED, $userSession);
            $post = PostManager::get($id);
            if($post != null)
            {
            echo "formEditPost";
            echo "<br>created_at :" . $post['created_at'];
            echo    "<form action ='editPost' method ='post'>
                        <input name='auteur' value='".$post['auteur']."'>
                        <input name='titre' value='".$post['titre']."'>
                        <input name='chapo' value='".$post['chapo']."'>
                        <input name='contenu' value='".$post['contenu']."'>
                        <input type='submit' name ='submit' value='ok'>
                    </form>";
            }
            else
            {
                echo 'redirection ce post n\'existe pas.';
            }
            
        }
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
        }
    }
    
    //NOT FORM
    //get for the front-end
    public static function get(String $id)
    {
        try
        {
            $post = PostManager::get($id);
            if($post != null)
            {
                echo 'Post ' , var_dump($post);
                require dirname(__DIR__) . "../model/CommentManager.php";
                $commentsPublished = CommentManager::getAllPostPublished($id);
                echo '<br>published comment: ' , var_dump ($commentsPublished);
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

    //get for the back-end
    public static function getBack(String $id, $userSession)
    {
        try
        {
            PostController::permission(ADMIN, $userSession); 

            $post = PostManager::get($id);
            if($post != null)
            {
                echo 'Post ' , var_dump($post);
                require dirname(__DIR__) . "../model/CommentManager.php";
                $commentsPublished = CommentManager::getAllPostPublished($id);
                $commentsNotPublished = CommentManager::getAllPostNotPublished($id);
                echo '<br>published' , var_dump ($commentsPublished);
                echo '<br>not published' , var_dump ($commentsNotPublished);
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
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
        }
    }

    public static function getAll()
    {
        try 
        {
            $posts = PostManager::getAll();
            if($posts != null)
            {
                var_dump($posts);
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

    public static function push( $auteur, $titre, $chapo, $contenu, $userSession)
    {
        try{
            
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

    public static function edit($id, $auteur, $titre, $chapo, $contenu, $userSession)
    {
        try
        { 
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

    public static function delete( $id, $userSession)
    {
        try
        {
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