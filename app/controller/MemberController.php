<?php

namespace App\Controller;

use App\Entity\MemberEntity;
use App\Exception\AccessViolationException;
use App\Model\MemberManager;
use App\Session\BlogSession;
use App\View\MemberView;
use Symfony\Component\HttpFoundation\Request;

Class MemberController extends Controller
{
    public static function getCV()
    {
        return(MemberView::getCV());
    }

    public static function administration()
    {
        try
        {
            MemberController::permission(ADMIN, BlogSession::getUser());
            return(MemberView::administration(BlogSession::getUser()));
        }
        catch (AccessViolationException $e)
        {
            return(MemberController::ifAccessViolationExceptionView($e));
        }
    }

    public static function home()
    {
        return(MemberView::home(BlogSession::getUser()));
    }

    //FORM
    public static function login()
    {
        return(MemberView::login());
    }
    
    public static function signUp()
    {
        return(MemberView::signUp());
    }

    public static function formEditPassword()
    {
        try
        {
            MemberController::permission(USER_AUTHENTIFIED, BlogSession::getUser());
            return(MemberView::formEditPassword(BlogSession::getUser()));
        }
        catch (AccessViolationException $e)
        {
            return(MemberController::ifAccessViolationExceptionView($e));
        }
    }

    // NOT FORM
    public static function auth(Request $request)
    {
        if( null !== $request->get("login")
            && null !== $request->get("password"))
        {
            try
            {
                $login = $request->get("login");
                $password = $request->get("password");
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
                    BlogSession::setUser($memberEntity);
                    return(MemberView::success());
                }
                else
                {
                    return(MemberView::errorMessage("authFail", [
                        "login"=>$login
                    ]));
                }
            }
            catch (\PDOException $e)
            {
                return(MemberController::ifPDOExceptionView($e));
            }
        }
        else
        {
            return MemberView::errorForm();
        }
    }

    public static function push(Request $request)
    {
        if( null !== $request->get("login")
            && null !==$request->get("password"))
        {
            try
            {
                $login = $request->get("login");
                $password = $request->get("password");
                //check if member exists
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
                        BlogSession::setUser($memberEntity);
                        return(MemberView::success());
                        header('Location:'.self::getRoot());
                    }
                    else
                    {
                        return(MemberView::errorMessage("pushFail"));
                    }
                }
                else
                {
                    return(MemberView::errorMessage("memberExists", [
                        "login"=>$login
                    ]));
                }
            }
            catch (\PDOException $e)
            {
                return(MemberController::ifPDOExceptionView($e));
            }
        }
        else
        {
            return MemberView::errorForm();
        }
    }

    public static function editPassword(Request $request)
    {
        if(null !== $request->get("oldPassword")
           && null !==  $request->get("newPassword")
           && null !==  $request->get("token"))
        {
            try
            {
                $oldPassord = $request->get("oldPassword");
                $newPassword = $request->get("newPassword");
                $tokenSent = $request->get("token");
                //use js for check new password and confirmNewPassword
                $userSession = BlogSession::getUser();
                
                MemberController::permission(USER_AUTHENTIFIED, $userSession, $tokenSent);
                if( $userSession->getPassword() === $oldPassord)
                {
                    $userSession->setPassword($newPassword);
                    //update SESSION USER
                    BlogSession::setUser($userSession);
                    MemberManager::editPassword($userSession);
                    return(MemberView::success());
                }
                else
                {
                    return(MemberView::error());
                }
            }
            catch (\PDOException $e)
            {
                return(MemberController::ifPDOExceptionView($e));
            }
            catch (AccessViolationException $e)
            {
                return(MemberController::ifAccessViolationExceptionView($e));
            }
        }
        else
        {
            return MemberView::errorForm();
        }
    }

    public static function disconnect()
    {
        BlogSession::disconnect();
        header('Location:'.self::getRoot());
    }
}