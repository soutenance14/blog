<?php

namespace App\Controller;

require dirname(__DIR__) . '../../vendor/autoload.php';

use App\Entity\CommentEntity;
use App\Entity\PostEntity;
use App\Exception\AccessViolationException;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\PostView;
use App\View\View;
use \Cocur\Slugify\Slugify;

Abstract Class PostController extends Controller
{
    // FORM
    public static function formPushPost($userSession)
    {
        try
        {
            self::permission(ADMIN, $userSession );
            return(PostView::formPushPost($userSession));
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
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
                return(PostView::formEditPost($postEntity, $userSession));
            }
            else
            {
                return(PostView::getNotExist($id, $userSession));
            } 
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
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
                return(PostView::get($postEntity, $listCommentsPublishedEntity, $userSession));
            }
            else
            {
                return(PostView::getNotExist($slug, $userSession));
            }
        }
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
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

                return(PostView::getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $userSession, $slug));
            }
            else
            {
               return(PostView::getNotExist($slug, $userSession));
            }
        }
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
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
                return(PostView::getAll($listPostsEntity, $user));
            }
            else
            {
                return(PostView::getNoPostExist($user));
            }
        } 
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
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
                return(PostView::getAllBack($listPostsEntity, $userSession));
            }
            else
            {
                return(PostView::getNoPostExist($userSession));
            }
        } 
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
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
                return(PostView::success());
            }
            else
            {
                return(PostView::pushFail($userSession));
            }
        }
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
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
                return(PostView::success());
            }
            else
            {
                return(PostView::editFail($userSession));
            }
        }
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
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
                return(PostView::deleteFail($userSession));
            } 
        }
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
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