<?php

require dirname(__DIR__) . '../../vendor/autoload.php';
// define('USER_NOT_AUTHENTIFIED', null);
// define('USER_AUTHENTIFIED', 0);
// define('ADMIN', 1);

Abstract Class PostController
{
    public static function home()
    {
        echo MemberView::home();
    }

    // FORM
    public static function formPushPost($userSession)
    {
        try
        {
            PostController::permission(ADMIN, $userSession );
            echo PostView::formPushPost($userSession);
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
            PostController::permission(ADMIN, $userSession);
            $post = PostManager::get($id);
            $postEntity = new PostEntity();
            $postEntity->hydrate($post);
            if($post != null)
            {
                echo PostView::formEditPost($postEntity, $userSession);
            }
            else
            {
                echo PostView::getNotExist($id);
            }
            
        }
        catch (AccessViolationException $e)
        {
            PostController::ifAccessViolationExceptionView($e);
        }
    }
    
    //NOT FORM
    //get for the front-end
    public static function get(String $id, $userSession)
    {
        try
        {
            $post = PostManager::get($id);
            if($post != null)
            {
                $postEntity = new PostEntity($post);
                $postEntity->hydrate($post);
                // require dirname(__DIR__) . "../model/CommentManager.php";
                $listCommentsPublished = CommentManager::getAllPostPublished($id);
                $listCommentsPublishedEntity = [];
                foreach($listCommentsPublished as $commentPublished)
                {
                    $commentPublishedEntity = new CommentEntity();
                    $commentPublishedEntity->hydrate($commentPublished);
                    array_push( $listCommentsPublishedEntity , $commentPublishedEntity);
                }
                $commentViewPublished = CommentView::getAll($listCommentsPublishedEntity, "Commentaires", $userSession);
                echo PostView::get($postEntity, $commentViewPublished, $userSession);
            }
            else
            {
                echo PostView::getNotExist($id);
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
                $postEntity = new PostEntity($post);
                $postEntity->hydrate($post);
                // require dirname(__DIR__) . "../model/CommentManager.php";
                $listCommentsPublished = CommentManager::getAllPostPublished($id);
                $listCommentsPublishedEntity = [];
                foreach($listCommentsPublished as $commentPublished)
                {
                    $commentPublishedEntity = new CommentEntity();
                    $commentPublishedEntity->hydrate($commentPublished);
                    array_push( $listCommentsPublishedEntity , $commentPublishedEntity);
                }
                
                $listCommentsNotPublished = CommentManager::getAllPostNotPublished($id);
                $listCommentsNotPublishedEntity = [];
                foreach($listCommentsNotPublished as $commentNotPublished)
                {
                    $commentNotPublishedEntity = new CommentEntity();
                    $commentNotPublishedEntity->hydrate($commentNotPublished);
                    array_push( $listCommentsNotPublishedEntity , $commentNotPublishedEntity);
                }
                
                $commentViewPublished = CommentView::getAll($listCommentsPublishedEntity, "Publiés", $userSession);
                $commentViewNotPublished = CommentView::getAll($listCommentsNotPublishedEntity, "Non publiés", $userSession);

                echo PostView::getBack($postEntity, $commentViewPublished, $commentViewNotPublished, $userSession);
            }
            else
            {
               echo PostView::getNotExist($id);
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
                $listPostsEntity = [];
                foreach($posts as $post)
                {
                    $postEntity = new PostEntity();
                    $postEntity->hydrate($post);
                    array_push($listPostsEntity, $postEntity);
                }
                echo PostView::getAll($listPostsEntity);
            }
            else
            {
                echo PostView::getNoPostExist();
            }
        } 
        catch (\PDOException $e)
        {
            PostController::ifPDOExceptionView($e);
        }
    }
    
    public static function getAllBack($userSession)
    {
        try 
        {
            PostController::permission(ADMIN, $userSession);
            $posts = PostManager::getAll();
            if($posts != null)
            {
                $listPostsEntity = [];
                foreach($posts as $post)
                {
                    $postEntity = new PostEntity();
                    $postEntity->hydrate($post);
                    array_push($listPostsEntity, $postEntity);
                }
                echo PostView::getAllBack($listPostsEntity, $userSession->getToken());
            }
            else
            {
                echo PostView::getNoPostExist();
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

    public static function push( $auteur, $titre, $chapo, $contenu, $tokenSent, $userSession)
    {
        try{
            
            PostController::permissionToken(ADMIN, $userSession, $tokenSent); 
            $postEntity = new PostEntity();
            $postEntity->hydrate(
                array(
                    "auteur"=>$auteur,
                    "titre"=>$titre,
                    "chapo"=>$chapo,
                    "contenu"=>$contenu,
                    )
            );
            $requestSuccess = PostManager::push( $postEntity);
            if($requestSuccess != null)
            {
                echo 'header:location/blog/posts';
            }
            else
            {
                echo PostView::pushFail();
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

    public static function edit($id, $auteur, $titre, $chapo, $contenu, $tokenSent, $userSession)
    {
        try
        { 
            PostController::permissionToken(ADMIN, $userSession, $tokenSent); 
            
            $postEntity = new PostEntity();
            $postEntity->hydrate(
                array(
                    "id"=>$id,
                    "auteur"=>$auteur,
                    "titre"=>$titre,
                    "chapo"=>$chapo,
                    "contenu"=>$contenu,
                    )
            );
            $requestSuccess = PostManager::edit($postEntity);
            if($requestSuccess != null)
            {
                echo 'header:location/blog/posts';
            }
            else
            {
                echo PostView::editFail();
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

    public static function delete( $id, $tokenSent, $userSession)
    {
        try
        {
            PostController::permissionToken(ADMIN, $userSession, $tokenSent); 

            $requestSuccess = PostManager::delete( $id);
            if($requestSuccess == true)
            {
                echo 'header:location/blog/posts';
            }
            else
            {
                echo PostView::deleteFail();
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
    
    private static function permissionToken(String $permission, $user, $tokenSent)
    {
        Controller::permissionToken($permission, $user, $tokenSent);
    }
}