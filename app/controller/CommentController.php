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
            CommentController::permission(USER_AUTHENTIFIED, $userSession, $tokenSent);
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
            CommentController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            CommentController::ifAccessViolationExceptionView($e);
        }
    }

    public static function setPublished($id, $published, $tokenSent, $userSession)
    {
        if( $published === '0' || $published === '1')
        {
            try
            {
                CommentController::permission(ADMIN, $userSession, $tokenSent);
                $commentEntity = new CommentEntity();
                $commentEntity->setId($id);
                $commentEntity->setPublished($published);
                $requestSuccess = CommentManager::setPublished($commentEntity);
                if($requestSuccess === true)
                {
                    echo 'redirection setPublished comment success.';
                }
                else
                {
                    echo 'redirection setPublished comment failed.';
                }
            }
            catch (\PDOException $e)
            {
                CommentController::ifPDOExceptionView($e);
            }
            catch (AccessViolationException $e)
            {
                CommentController::ifAccessViolationExceptionView($e);
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
                CommentController::permissionThisIdMember( $userSession, $commentEntity->getIdMembre(), $tokenSent);
                
                $requestSuccess = CommentManager::delete( $id);
                if($requestSuccess === true)
                {
                    echo 'redirection delete comment success.';
                    var_dump($requestSuccess);
                }
                else
                {
                    echo 'redirection delete comment failed.';
                }
            }
            else
            {
                echo 'Ce commentaire n\'existe pas.';
            }
        }
        catch (\PDOException $e)
        {
            CommentController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            CommentController::ifAccessViolationExceptionView($e);
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
    
    private static function permissionThisIdMember( $user, $id_member_permission, $tokenSent)
    {
        require dirname(__DIR__) . "../exception/AccessViolationException.php";
        if($user->getPermission() != USER_NOT_AUTHENTIFIED && $user->getToken() === $tokenSent) 
        {
            echo '<br>'.$user->getPermission().'<br>';
            if( ($user->getId() != $id_member_permission) && ($user->getPermission() != ADMIN)    )
            {
                throw new AccessViolationException('user is not the owner and not admin.', 101);
            }
        }
        else
        {
            throw new AccessViolationException('User not authenfied.', 97);
        }
    }

}