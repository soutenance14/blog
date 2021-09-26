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
            return(PostView::formPushPost(BlogSession::getUser()));
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
                return(PostView::get($postEntity, $listCommentsPublishedEntity, BlogSession::getUser()));
            }
            else
            {
                //no ajax
                return(PostView::getNotExist($slug, BlogSession::getUser()));
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
            $userSession = BlogSession::getUser();
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
                //no ajax
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
                return(PostView::getAll($listPostsEntity, BlogSession::getUser()));
            }
            else
            {
                //no ajax
                return(PostView::getNoPostExist(BlogSession::getUser()));
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
            $userSession = BlogSession::getUser();
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
                //no ajax
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

    public static function push(Request $request)
    {
        if( null !== $request->get("auteur")
            && null !== $request->get("titre")
            && null !== $request->get("chapo")
            && null !== $request->get("contenu")
            && null !== $request->get("tokenSent"))
        {
            $auteur = $request->get("auteur");
            $titre = $request->get("titre");
            $chapo = $request->get("chapo");
            $contenu = $request->get("contenu");
            $tokenSent = $request->get("token");
            try
            {
                self::permissionToken(ADMIN, BlogSession::getUser(), $tokenSent); 
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
        if( null !== $request->get("id")
            && null !== $request->get("auteur")
            && null !== $request->get("titre")
            && null !== $request->get("chapo")
            && null !== $request->get("contenu")
            && null !== $request->get("token"))
        {
            try
            { 
                $id = $request->get("id");
                $auteur = $request->get("auteur");
                $titre = $request->get("titre");
                $chapo = $request->get("chapo");
                $contenu = $request->get("contenu");
                $tokenSent = $request->get("token");
                self::permissionToken(ADMIN, BlogSession::getUser(), $tokenSent); 
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

    public static function delete( $id, $tokenSent)
    {
        try
        {
            self::permissionToken(ADMIN, BlogSession::getUser(), $tokenSent); 

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