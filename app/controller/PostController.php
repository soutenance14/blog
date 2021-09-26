<?php

namespace App\Controller;

use App\Entity\CommentEntity;
use App\Entity\PostEntity;
use App\Exception\AccessViolationException;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Session\BlogSession;
use App\View\PostView;
use App\View\View;
use \Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\Request;

Abstract Class PostController extends Controller
{
    // FORM
    public static function formPushPost()
    {
        try
        {
            self::permission(ADMIN, BlogSession::getUser() );
            return(PostView::formPushPost());
        }
        catch (AccessViolationException $e)
        {
            return(self::ifAccessViolationExceptionView($e));
        }
    }
    
    public static function formEditPost(String $id)
    {
        try
        {
            $userSession = BlogSession::getUser();
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
                //no ajax
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
    public static function get(String $slug)
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
                return(PostView::get($postEntity, $listCommentsPublishedEntity));
            }
            else
            {
                //no ajax
                return(PostView::getNotExist($slug));
            }
        }
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
        }
    }

    //get for the back-end
    public static function getBack(String $slug)
    {
        try
        {
            self::permission(ADMIN, BlogSession::getUser());

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

                return(PostView::getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $slug));
            }
            else
            {
                //no ajax
               return(PostView::getNotExist($slug));
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
                return(PostView::getAll($listPostsEntity));
            }
            else
            {
                //no ajax
                return(PostView::getNoPostExist());
            }
        } 
        catch (\PDOException $e)
        {
            return(self::ifPDOExceptionView($e));
        }
    }
    
    public static function getAllBack()
    {
        try 
        {
            self::permission(ADMIN, BlogSession::getUser());
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
                return(PostView::getAllBack($listPostsEntity));
            }
            else
            {
                //no ajax
                return(PostView::getNoPostExist());
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

    public static function push(Request $request)
    {
        if( Controller::checkForm($request, [
            "auteur",
            "titre",
            "chapo",
            "contenu",
            "token"]))
        {
            try
            {
                self::permissionToken(ADMIN, BlogSession::getUser(), $request->get("token")); 
                $slugify = new Slugify();
                $slug = $slugify->slugify($request->get("titre")); 
                $postEntity = new PostEntity();
                $postEntity->hydrate(
                array(
                    "auteur"=>$request->get("auteur"),
                    "titre"=>$request->get("titre"),
                    "slug"=>$slug,
                    "chapo"=>$request->get("chapo"),
                    "contenu"=>$request->get("contenu"),
                    )
                );
                $requestSuccess = PostManager::push( $postEntity);
                if($requestSuccess != null)
                {
                    return(PostView::success());
                }
                else
                {
                    return(PostView::errorMessage("pushFail"));
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
        else
        {
            return PostView::errorForm();
        }
    }
            
    public static function edit($request)
    {
        if( Controller::checkForm($request, [
            "id",
            "auteur",
            "titre",
            "chapo",
            "contenu",
            "token"]))
        {
            try
            { 
                self::permissionToken(ADMIN, BlogSession::getUser(), $request->get("token")); 
                $slugify = new Slugify();
                $slug = $slugify->slugify($request->get("titre")); 
                $postEntity = new PostEntity();
                $postEntity->hydrate(
                    array(
                        "id"=>$request->get("id"),
                        "auteur"=>$request->get("auteur"),
                        "titre"=>$request->get("titre"),
                        "slug"=>$slug,
                        "chapo"=>$request->get("chapo"),
                        "contenu"=>$request->get("contenu"),
                        )
                );
                $requestSuccess = PostManager::edit($postEntity);
                if($requestSuccess != null)
                {
                    return(PostView::success());
                }
                else
                {
                    return(PostView::errorMessage("editFail"));
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
        else
        {
            return PostView::errorForm();
        }
    }

    public static function delete( $id, $token)
    {
        //get call, no post
        try
        {
            self::permissionToken(ADMIN, BlogSession::getUser(), $token); 

            $requestSuccess = PostManager::delete( $id);
            if($requestSuccess == true)
            {
                header('Location:'.self::getRoot().'postsBack');
            }
            else
            {
                return(PostView::errorMessage("deleteFail"));
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