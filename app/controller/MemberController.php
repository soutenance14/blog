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
        print_r(MemberView::cv());
    }

    public static function administration($userSession)
    {
        try
        {
            MemberController::permission(ADMIN, $userSession);
            print_r(MemberView::administration($userSession));
        }
        catch (AccessViolationException $e)
        {
            print_r(MemberController::ifAccessViolationExceptionView($e));
        }
    }

    public static function home($userSession)
    {
        print_r(MemberView::home($userSession));
    }

    //FORM
    public static function login()
    {
        print_r(MemberView::login());
    }
    
    public static function signUp()
    {
        print_r(MemberView::signUp());
    }

    public static function formEditPassword($userSession)
    {
        try
        {
            MemberController::permission(USER_AUTHENTIFIED, $userSession);
            print_r(MemberView::formEditPassword($userSession));
        }
        catch (AccessViolationException $e)
        {
            print_r(MemberController::ifAccessViolationExceptionView($e));
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
                print_r(MemberView::success());
            }
            else
            {
                print_r(MemberView::authFail($login));
            }
        }
        catch (\PDOException $e)
        {
            print_r(MemberController::ifPDOExceptionView($e));
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
                    print_r(MemberView::success());
                    header('Location:'.self::getRoot());
                }
                else
                {
                    print_r(MemberView::pushFail());
                }
            }
            else
            {
                print_r(MemberView::memberExist($login));
            }
        }
        catch (\PDOException $e)
        {
            print_r(MemberController::ifPDOExceptionView($e));
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
                    print_r(MemberView::wrongLoginForUser($login, $id_member_to_delete));
                }
            }
            else
            {
                print_r(MemberView::deleteFail($login, $id_member_to_delete));
            }
        }
        catch (\PDOException $e)
        {
            print_r(MemberController::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            print_r(MemberController::ifAccessViolationExceptionView($e));
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
                print_r(MemberView::success());
            }
            else
            {
                print_r(MemberView::error());
            }
        }
        catch (\PDOException $e)
        {
            print_r(MemberController::ifPDOExceptionView($e));
        }
        catch (AccessViolationException $e)
        {
            print_r(MemberController::ifAccessViolationExceptionView($e));
        }
    }

    public static function disconnect($blogSession)
    {
        $blogSession->disconnect();
        header('Location:'.self::getRoot());
    }
}