<?php
namespace App\Controller;

use App\Entity\CommentEntity;
use App\Entity\PostEntity;
use App\Exception\AccessViolationException;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Session\BlogSession;
use App\View\CommentView;
use Symfony\Component\HttpFoundation\Request;

Abstract Class CommentController extends Controller
{
    public static function push(Request $request)
    {
        if( null !== $request->get("id_post")
            && null !== $request->get("contenu")
            && null !== $request->get("token"))
        {
            try
            {
                $userSession = BlogSession::getUser();
                $id_post = $request->get("id_post");
                $contenu = $request->get("contenu");
                $tokenSent = $request->get("token");
                
                CommentController::permissionToken(USER_AUTHENTIFIED, $userSession, $tokenSent);
                $commentEntity = new CommentEntity();
                $commentEntity->setIdMembre($userSession->getId());
                $commentEntity->setIdPost($id_post);
                $commentEntity->setContenu($contenu);
                $requestSuccess = null;
                if($userSession->getType() === 'admin')
                {
                //    if user is admin, comment is published
                    $requestSuccess = CommentManager::pushPublished( $commentEntity);
                }
                else
                {
                    $requestSuccess = CommentManager::pushNotPublished( $commentEntity);
                }

                if($requestSuccess === true)
                {
                    return(CommentView::success());
                }
                else
                {
                    return(CommentView::error());
                }
            }
            catch (\PDOException $e)
            {
                return(CommentController::ifPDOExceptionView($e));
            }
            catch (AccessViolationException $e)
            {
                return(CommentController::ifAccessViolationExceptionView($e));
            }
        }
        else
        {
            return CommentView::errorForm();
        }
    }

    public static function setPublished($id, $published, $tokenSent)
    {
        if( $published === '0' || $published === '1')
        {
            try
            {
                CommentController::permissionToken(ADMIN, BlogSession::getUser(), $tokenSent);
                $commentEntity = new CommentEntity();
                $commentEntity->setId($id);
                $commentEntity->setPublished($published);
                $requestSuccess = CommentManager::setPublished($commentEntity);
                if($requestSuccess === true)
                {
                    //recuperation de l'id_post pour la redirection
                    // on aurait pu envoyé l'id dans l'url des le depart
                    // ici on s'assure que l'on récupère le bon id_post
                    $comment = CommentManager::get($id);
                    $commentEntity->hydrate($comment);

                    $post = PostManager::getFromId($commentEntity->getIdPost());
                    $postEntity = new PostEntity();
                    $postEntity->hydrate($post);

                    header("Location:".self::getRoot()."post/back/".$postEntity->getSlug());
                
                }
                else
                {
                    return(CommentView::error());
                }
            }
            catch (\PDOException $e)
            {
                return(CommentController::ifPDOExceptionView($e));
            }
            catch (AccessViolationException $e)
            {
                return(CommentController::ifAccessViolationExceptionView($e));
            }
        }
        else
        {
            //no ajax
            return(CommentView::wrongValueEditComment(BlogSession::getUser()));
        }
    }

    public static function delete($id, $tokenSent)
    {
        try
        {
            $comment = CommentManager::get($id);
            if($comment != null)
            {
                $commentEntity = new CommentEntity();
                $commentEntity->hydrate($comment);
                CommentController::permissionThisIdMember( BlogSession::getUser(), $commentEntity->getIdMembre(), $tokenSent);
                
                $requestSuccess = CommentManager::delete( $id);
                if($requestSuccess === true)
                {
                    $post = PostManager::getFromId($commentEntity->getIdPost());
                    $postEntity = new PostEntity();
                    $postEntity->hydrate($post);
                    $type = BlogSession::getUser()->getType();
                    if($type === "admin")
                    {
                        header("Location:".self::getRoot()."post/back/".$postEntity->getSlug());
                    }
                    else
                    {
                        header("Location:".self::getRoot()."post/".$postEntity->getSlug());
                    }
                }
                else
                {
                    return(CommentView::error());
                }
            }
            else
            {
                return(CommentView::error());
            }
        }
        catch (\PDOException $e)
        {
            return(CommentController::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            return(CommentController::ifAccessViolationExceptionView($e));
        }
    }

}