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
                // si l'user est un admin, le commentaire est directement publié
                $requestSuccess = CommentManager::pushPublished( $commentEntity);
            }
            else
            {
                // si l'user n'est pas un admin, le commentaire n'est pas publié
                $requestSuccess = CommentManager::pushNotPublished( $commentEntity);
            }

            if($requestSuccess === true)
            {
                echo 'success';
            }
            else
            {
                echo 'Votre commentaire n\' a pas été enregistré, veuillez réessayer.';
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
                // if($requestSuccess === true)
                // {
                    //recuperation de l'id_post pour la redirection
                    // on aurait pu envoyé l'id dans l'url des le depart
                    // ici on s'assure que l'on récupère le bon id_post
                    $comment = CommentManager::get($id);
                    $commentEntity->hydrate($comment);

                    $post = PostManager::getFromId($commentEntity->getIdPost());
                    $postEntity = new PostEntity();
                    $postEntity->hydrate($post);

                    header("Location:".self::getRoot()."post/back/".$postEntity->getSlug());
                
                // }
                // else
                // {
                //     header("Location:".self::getRoot()."posts");
                //     // echo 'redirection setPublished comment failed.';
                // }
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
            echo 'mauvaise valeur donnée.';
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
                //TODO A MOODIFIER ICI
                // var_dump($commentEntity);
                CommentController::permissionThisIdMember( $userSession, $commentEntity->getIdMembre(), $tokenSent);
                
                $requestSuccess = CommentManager::delete( $id);
                // if($requestSuccess === true)
                // {
                    $post = PostManager::getFromId($commentEntity->getIdPost());
                    $postEntity = new PostEntity();
                    $postEntity->hydrate($post);

                    header("Location:".self::getRoot()."post/back/".$postEntity->getSlug());
                // }
                // else
                // {
                //     echo CommentView::deleteFail($userSession);
                // }
            }
            else
            {
                echo CommentView::getNotExist($id, $userSession);
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