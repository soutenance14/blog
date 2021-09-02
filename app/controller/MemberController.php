<?php
require dirname(__DIR__) . '../../vendor/autoload.php';

 Class MemberController extends Controller
{

    public static function home($userSession)
    {
        echo MemberView::home($userSession);
    }

    //FORM
    public static function login()
    {
        echo MemberView::login();
    }
    
    public static function signUp()
    {
        echo MemberView::signUp();
    }
    
    public static function formDelete($userSession)
    {
        try
        {
            MemberController::permission(USER_AUTHENTIFIED, $userSession);
            // echo MemberView::formDelete($userSession);
        }
        catch (AccessViolationException $e)
        {
            echo MemberController::ifAccessViolationExceptionView($e);
        }
    }

    public static function formDeleteBack($userSession)
    {
        try
        {
            MemberController::permission(ADMIN, $userSession);
            $listSubscribersEntity = [];
            // $listSubscribers = MemberManager::getAllSubscribers();
            
            // foreach($listSubscribers as $subscriber)
            // {
            //     $memberEntity = new MemberEntity();
            //     $memberEntity->hydrate($subscriber);
            //     array_push($listSubscribersEntity, $memberEntity);
            // }

            // echo MemberView::formDeleteBack($userSession, $listSubscribersEntity);
        }
        catch (\PDOException $e)
        {
            echo MemberController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo MemberController::ifAccessViolationExceptionView($e);
        }
    }

    public static function formEditPassword($userSession)
    {
        try
        {
            MemberController::permission(USER_AUTHENTIFIED, $userSession);
            echo MemberView::formEditPassword($userSession);
        }
        catch (AccessViolationException $e)
        {
            echo MemberController::ifAccessViolationExceptionView($e);
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
                // echo'member model' , var_dump($memberEntity);
                // echo '<br> session user' , var_dump($blogSession->getUser());
                echo 'success';
            }
            else
            {
                echo 'Erreur, l\'utilisateur n\'a pas été trouvé, veuillez réessayer.';
            }
        }
        catch (\PDOException $e)
        {
            echo MemberController::ifPDOExceptionView($e);
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
                    echo 'header:location/home';
                }
                else
                {
                    echo MemberView::pushFail();
                }
            }
            else
            {
                echo MemberView::memberExist($login);
            }
        }
        catch (\PDOException $e)
        {
            echo MemberController::ifPDOExceptionView($e);
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
                    echo MemberView::wrongLoginForUser($login, $id_member_to_delete);
                }
            }
            else
            {
                echo MemberView::deleteFail($login, $id_member_to_delete);
            }
        }
        catch (\PDOException $e)
        {
            echo MemberController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo MemberController::ifAccessViolationExceptionView($e);
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
                echo 'success';
            }
            else
            {
                echo 'L\'ancien mot de passe est érroné.'.$oldPassord;
            }
        }
        catch (\PDOException $e)
        {
            echo MemberController::ifPDOExceptionView($e);
        }
        catch (AccessViolationException $e)
        {
            echo MemberController::ifAccessViolationExceptionView($e);
        }
    }

    public static function disconnect($blogSession)
    {
        $blogSession->disconnect();
        header('Location:home');
    }

}