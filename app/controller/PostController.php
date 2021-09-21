<?php
require dirname(__DIR__) . '../../vendor/autoload.php';
use \Cocur\Slugify\Slugify;

Abstract Class PostController extends Controller
{
    // FORM
    public static function formPushPost($userSession)
    {
        try
        {
            self::permission(ADMIN, $userSession );
            echo PostView::formPushPost($userSession);
        }
        catch (AccessViolationException $e)
        {
            echo self::ifAccessViolationExceptionView($e);
        }
    }
    
    public static function formEditPost(String $id, $userSession)
    {
        try
        {
            self::permission(ADMIN, $userSession);
            $post = PostManager::getFromId($id);
            $postEntity = new PostEntity();
            $postEntity->hydrate($post);
            if($post != null)
            {
                echo PostView::formEditPost($postEntity, $userSession);
            }
            else
            {
                echo PostView::getNotExist($id, $userSession);
            } 
        }
        catch (AccessViolationException $e)
        {
            echo self::ifAccessViolationExceptionView($e);
        }
    }
    
    //NOT FORM
    //get for the front-end
    public static function get(String $slug, $userSession)
    {
        try
        {
            $post = PostManager::get($slug);
            if($post != null)
            {
                $postEntity = new PostEntity($post);
                $postEntity->hydrate($post);
                $listCommentsPublished = CommentManager::getAllPublished($postEntity->getId());
                $listCommentsPublishedEntity = [];
                foreach($listCommentsPublished as $commentPublished)
                {
                    $commentPublishedEntity = new CommentEntity();
                    $commentPublishedEntity->hydrate($commentPublished);
                    array_push( $listCommentsPublishedEntity , $commentPublishedEntity);
                }
                echo PostView::get($postEntity, $listCommentsPublishedEntity, $userSession);
            }
            else
            {
                echo PostView::getNotExist($slug, $userSession);
            }
        }
        catch (\PDOException $e)
        {
            echo self::ifPDOExceptionView($e);
        }
    }

    //get for the back-end
    public static function getBack(String $slug, $userSession)
    {
        try
        {
            self::permission(ADMIN, $userSession);

            $post = PostManager::get($slug);
            if($post != null)
            {
                $postEntity = new PostEntity($post);
                $postEntity->hydrate($post);
                $listCommentsPublished = CommentManager::getAllPublished($postEntity->getId());
                $listCommentsPublishedEntity = [];
                foreach($listCommentsPublished as $commentPublished)
                {
                    $commentPublishedEntity = new CommentEntity();
                    $commentPublishedEntity->hydrate($commentPublished);
                    array_push( $listCommentsPublishedEntity , $commentPublishedEntity);
                }
                
                $listCommentsNotPublished = CommentManager::getAllNotPublished($postEntity->getId());
                $listCommentsNotPublishedEntity = [];
                foreach($listCommentsNotPublished as $commentNotPublished)
                {
                    $commentNotPublishedEntity = new CommentEntity();
                    $commentNotPublishedEntity->hydrate($commentNotPublished);
                    array_push( $listCommentsNotPublishedEntity , $commentNotPublishedEntity);
                }

                echo PostView::getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $userSession, $slug);
            }
            else
            {
               echo PostView::getNotExist($slug, $userSession);
            }
        }
        catch (\PDOException $e)
        {
            echo self::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo self::ifAccessViolationExceptionView($e);
        }
    }

    public static function getAll($user)
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
                echo PostView::getAll($listPostsEntity, $user);
            }
            else
            {
                echo PostView::getNoPostExist($user);
            }
        } 
        catch (\PDOException $e)
        {
            echo self::ifPDOExceptionView($e);
        }
    }
    
    public static function getAllBack($userSession)
    {
        try 
        {
            self::permission(ADMIN, $userSession);
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
                echo PostView::getAllBack($listPostsEntity, $userSession);
            }
            else
            {
                echo PostView::getNoPostExist($userSession);
            }
        } 
        catch (\PDOException $e)
        {
            echo self::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo self::ifAccessViolationExceptionView($e);
        }
    }

    public static function push( $auteur, $titre, $chapo, $contenu, $tokenSent, $userSession)
    {
        try{
            self::permissionToken(ADMIN, $userSession, $tokenSent); 
            $slugify = new Slugify();
            $slug = $slugify->slugify($titre); 
            $postEntity = new PostEntity();
            $postEntity->hydrate(
                array(
                    "auteur"=>$auteur,
                    "titre"=>$titre,
                    "slug"=>$slug,
                    "chapo"=>$chapo,
                    "contenu"=>$contenu,
                    )
            );
            $requestSuccess = PostManager::push( $postEntity);
            if($requestSuccess != null)
            {
                echo 'success';
            }
            else
            {
                echo PostView::pushFail($userSession);
            }
        }
        catch (\PDOException $e)
        {
            echo self::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo self::ifAccessViolationExceptionView($e);
        }
    }

    public static function edit($id, $auteur, $titre, $chapo, $contenu, $tokenSent, $userSession)
    {
        try
        { 
            self::permissionToken(ADMIN, $userSession, $tokenSent); 
            $slugify = new Slugify();
            $slug = $slugify->slugify($titre); 
            $postEntity = new PostEntity();
            $postEntity->hydrate(
                array(
                    "id"=>$id,
                    "auteur"=>$auteur,
                    "titre"=>$titre,
                    "slug"=>$slug,
                    "chapo"=>$chapo,
                    "contenu"=>$contenu,
                    )
            );
            $requestSuccess = PostManager::edit($postEntity);
            if($requestSuccess != null)
            {
                echo 'success';
            }
            else
            {
                echo PostView::editFail($userSession);
            }
        }
        catch (\PDOException $e)
        {
            echo self::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo self::ifAccessViolationExceptionView($e);
        }
    }

    public static function delete( $id, $tokenSent, $userSession)
    {
        try
        {
            self::permissionToken(ADMIN, $userSession, $tokenSent); 

            $requestSuccess = PostManager::delete( $id);
            if($requestSuccess == true)
            {
                header('Location:'.self::getRoot().'postsBack');
            }
            else
            {
                echo PostView::deleteFail($userSession);
            } 
        }
        catch (\PDOException $e)
        {
            echo self::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo self::ifAccessViolationExceptionView($e);
        }
    }

    public static function ifPDOExceptionView(\PDOException $e)
    {
        if($e->getCode() === "23000")// key constraint pb
        {
            return View::renderViewException(
                $e, "Problème de clé dans la base de données", "databaseError-bg", 
                "Champs similaire existant, faire une modification.");
        }
        else
        {
            return parent::ifPDOExceptionView($e);
        }
    }
}