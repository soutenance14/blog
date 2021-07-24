<?php

require dirname(__DIR__) . '../../vendor/autoload.php';
// define('USER_NOT_AUTHENTIFIED', null);
// define('USER_AUTHENTIFIED', 'subscriber');
// define('ADMIN', 'admin');

Abstract Class CommentController
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
                echo 'redirection push comment success.';
            }
            else
            {
                echo 'redirection push comment failed.';
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

    public static function setPublished($id, $published, $tokenSent, $userSession, $root)
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

                    header('Location:'.$root.'postBack/'.$commentEntity->getIdPost());
                }
                else
                {
                    echo 'redirection setPublished comment failed.';
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
                var_dump($commentEntity);
                CommentController::permissionThisIdMember( $userSession, $commentEntity->getIdMembre(), $tokenSent);
                
                $requestSuccess = CommentManager::delete( $id);
                if($requestSuccess === true)
                {
                    echo 'header:location/home.';
                }
                else
                {
                    echo CommentView::deleteFail();
                }
            }
            else
            {
                echo CommentView::getNotExist($id);
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

    private static function permissionToken(String $permission, $user, $tokenSent)
    {
        Controller::permissionToken($permission, $user, $tokenSent);
    }
    
    private static function permissionThisIdMember( $user, $id_member_permission, $tokenSent)
    {
        Controller::permissionThisIdMember( $user, $id_member_permission, $tokenSent);
    }

}