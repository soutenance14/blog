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
            print_r(PostView::formPushPost($userSession));
        }
        catch (AccessViolationException $e)
        {
            print_r(self::ifAccessViolationExceptionView($e));
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
                print_r(PostView::formEditPost($postEntity, $userSession));
            }
            else
            {
                print_r(PostView::getNotExist($id, $userSession));
            } 
        }
        catch (AccessViolationException $e)
        {
            print_r(self::ifAccessViolationExceptionView($e));
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
                print_r(PostView::get($postEntity, $listCommentsPublishedEntity, $userSession));
            }
            else
            {
                print_r(PostView::getNotExist($slug, $userSession));
            }
        }
        catch (\PDOException $e)
        {
            print_r(self::ifPDOExceptionView($e));
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

                print_r(PostView::getBack($postEntity, $listCommentsPublishedEntity, $listCommentsNotPublishedEntity, $userSession, $slug));
            }
            else
            {
               print_r(PostView::getNotExist($slug, $userSession));
            }
        }
        catch (\PDOException $e)
        {
            print_r(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            print_r(self::ifAccessViolationExceptionView($e));
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
                print_r(PostView::getAll($listPostsEntity, $user));
            }
            else
            {
                print_r(PostView::getNoPostExist($user));
            }
        } 
        catch (\PDOException $e)
        {
            print_r(self::ifPDOExceptionView($e));
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
                print_r(PostView::getAllBack($listPostsEntity, $userSession));
            }
            else
            {
                print_r(PostView::getNoPostExist($userSession));
            }
        } 
        catch (\PDOException $e)
        {
            print_r(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            print_r(self::ifAccessViolationExceptionView($e));
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
                print_r(PostView::success());
            }
            else
            {
                print_r(PostView::pushFail($userSession));
            }
        }
        catch (\PDOException $e)
        {
            print_r(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            print_r(self::ifAccessViolationExceptionView($e));
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
                print_r(PostView::success());
            }
            else
            {
                print_r(PostView::editFail($userSession));
            }
        }
        catch (\PDOException $e)
        {
            print_r(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            print_r(self::ifAccessViolationExceptionView($e));
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
                print_r(PostView::deleteFail($userSession));
            } 
        }
        catch (\PDOException $e)
        {
            print_r(self::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            print_r(self::ifAccessViolationExceptionView($e));
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