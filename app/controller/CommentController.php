<?php
require dirname(__DIR__) . '../../vendor/autoload.php';

Abstract Class CommentController extends Controller
{
    public static function push( $id_post, $contenu, $tokenSent, $userSession)
    {
        try
        {
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
                echo CommentView::success();
            }
            else
            {
                echo CommentView::error();
            }
        }
        catch (\PDOException $e)
        {
            echo CommentController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo CommentController::ifAccessViolationExceptionView($e);
        }
    }

    public static function setPublished($id, $published, $tokenSent, $userSession)
    {
        if( $published === '0' || $published === '1')
        {
            try
            {
                CommentController::permissionToken(ADMIN, $userSession, $tokenSent);
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
                    echo CommentView::error();
                }
            }
            catch (\PDOException $e)
            {
                echo CommentController::ifPDOExceptionView($e);
            }
            catch (AccessViolationException $e)
            {
                echo CommentController::ifAccessViolationExceptionView($e);
            }
        }
        else
        {
            //no ajax
            echo CommentView::wrongValueEditComment($userSession);
        }
    }

    public static function delete($id, $tokenSent, $userSession)
    {
        try
        {
            $comment = CommentManager::get($id);
            if($comment != null)
            {
                $commentEntity = new CommentEntity();
                $commentEntity->hydrate($comment);
                CommentController::permissionThisIdMember( $userSession, $commentEntity->getIdMembre(), $tokenSent);
                
                $requestSuccess = CommentManager::delete( $id);
                if($requestSuccess === true)
                {
                    $post = PostManager::getFromId($commentEntity->getIdPost());
                    $postEntity = new PostEntity();
                    $postEntity->hydrate($post);
                    $type = $userSession->getType();
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
                    echo CommentView::error();
                }
            }
            else
            {
                echo CommentView::error();
            }
        }
        catch (\PDOException $e)
        {
            echo CommentController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo CommentController::ifAccessViolationExceptionView($e);
        }
    }

}