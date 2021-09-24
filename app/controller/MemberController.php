<?php

namespace App\Controller;

use App\Entity\MemberEntity;
use App\Exception\AccessViolationException;
use App\Model\MemberManager;
use App\View\MemberView;

require dirname(__DIR__) . '../../vendor/autoload.php';


 Class MemberController extends Controller
{
    public static function cv()
    {
        print MemberView::cv();
    }

    public static function administration($userSession)
    {
        try
        {
            MemberController::permission(ADMIN, $userSession);
            print MemberView::administration($userSession);
        }
        catch (AccessViolationException $e)
        {
            print MemberController::ifAccessViolationExceptionView($e);
        }
    }

    public static function home($userSession)
    {
        print MemberView::home($userSession);
    }

    //FORM
    public static function login()
    {
        print MemberView::login();
    }
    
    public static function signUp()
    {
        print MemberView::signUp();
    }

    public static function formEditPassword($userSession)
    {
        try
        {
            MemberController::permission(USER_AUTHENTIFIED, $userSession);
            print MemberView::formEditPassword($userSession);
        }
        catch (AccessViolationException $e)
        {
            print MemberController::ifAccessViolationExceptionView($e);
        }
    }

    // NOT FORM
    public static function auth($login, $password, $blogSession)
    {
        try
        {
            $memberEntity = new MemberEntity();
            $memberEntity->setLogin($login);
            $memberEntity->setPassword($password);

            //seul les login et password sont crées pour le user
            // si l'auth est fait, les autres caracteristiques
            //seront recupérés dans la db
            $member = MemberManager::auth($memberEntity);
            if($member != null)
            {
                $memberEntity->hydrate($member);
                $blogSession->setUser($memberEntity);
                print MemberView::success();
            }
            else
            {
                print MemberView::authFail($login);
            }
        }
        catch (\PDOException $e)
        {
            print MemberController::ifPDOExceptionView($e);
        }
    }

    public static function push($login, $password, $blogSession)
    {
        try
        {
            //check if member exist
            $memberEntity = new MemberEntity();
            $memberEntity->setLogin($login);
            $memberEntity->setPassword($password);

            $loginNotExist = MemberManager::loginNotExist($memberEntity);
            if($loginNotExist)
            {
                $pushSuccess = MemberManager::push($memberEntity);
                if($pushSuccess === true)
                {
                    $member = MemberManager::auth($memberEntity);
                    //rehydrate memberEntity with model data
                    $memberEntity->hydrate($member);
                    $blogSession->setUser($memberEntity);
                    print MemberView::success();
                    header('Location:'.self::getRoot());
                }
                else
                {
                    print MemberView::pushFail();
                }
            }
            else
            {
                print MemberView::memberExist($login);
            }
        }
        catch (\PDOException $e)
        {
            print MemberController::ifPDOExceptionView($e);
        }
    }
    
    public static function delete($login, $id_member_to_delete, $tokenSent, $blogSession)
    {
        try
        {
            MemberController::permissionThisIdMember( $blogSession->getUser(), $id_member_to_delete, $tokenSent);
            $memberEntity = new MemberEntity();
            $memberEntity->setId($id_member_to_delete);
            $memberEntity->setLogin($login);
            $requestSuccess = MemberManager::delete($memberEntity);
            if($requestSuccess === true)
            {
                if( MemberManager::memberNotExist($id_member_to_delete)   )
                {
                    $blogSession->disconnect();
                }
                else
                {
                    print MemberView::wrongLoginForUser($login, $id_member_to_delete);
                }
            }
            else
            {
                print MemberView::deleteFail($login, $id_member_to_delete);
            }
        }
        catch (\PDOException $e)
        {
            print MemberController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            print MemberController::ifAccessViolationExceptionView($e);
        }
    }

    public static function editPassword($oldPassord, $newPassword, $tokenSent,$blogSession)
    {
        try
        {
            //use js for check new password and confirmNewPassword
            $userSession = $blogSession->getUser();
            
            MemberController::permission(USER_AUTHENTIFIED, $userSession, $tokenSent);
            if( $userSession->getPassword() === $oldPassord)
            {
                $userSession->setPassword($newPassword);
                //update SESSION USER
                $blogSession->setUser($userSession);
                MemberManager::editPassword($userSession);
                print MemberView::success();
            }
            else
            {
                print MemberView::error();
            }
        }
        catch (\PDOException $e)
        {
            print MemberController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            print MemberController::ifAccessViolationExceptionView($e);
        }
    }

    public static function disconnect($blogSession)
    {
        $blogSession->disconnect();
        header('Location:'.self::getRoot());
    }
}