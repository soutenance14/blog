<?php


// This is the router page
// use package Altorouter
// https://altorouter.com

use App\Controller\CommentController;
use App\Controller\ContactController;
use App\Controller\MemberController;
use App\Controller\PostController;
use App\Controller\RedirectionController;
use App\Session\BlogSession;

// use App\Session\BlogSession;

require dirname(__DIR__) . '../vendor/autoload.php';

//start AltoRouter
$router = new AltoRouter();


// ALL MAP ROUTES

// for user no auth
    //--GET
$router->map('GET', '/', 'home0');
$router->map('GET', '/home', 'home');
$router->map('GET', '/cv', 'cv');
$router->map('GET', '/admin/2d2823792eb6e1996c9a82cf3396546f', 'administration');
$router->map('GET', '/contact', 'formContact');
$router->map('GET', '/signUp', 'signUp');
$router->map('GET', '/login', 'login');
$router->map('GET', '/posts', 'posts');
$router->map('GET', '/posts/back', 'postsBack');
$router->map('GET', '/post/[:slug]', 'post');
$router->map('GET', '/post/back/[:slug]', 'postBack');

    //--POST
$router->map('POST', '/auth', 'auth');
$router->map('POST', '/pushMember', 'pushMember');
$router->map('POST', '/sendMessage', 'sendMessage');

// for user auth
    //--GET
$router->map('GET', '/disconnect', 'disconnect');
$router->map('GET', '/edit/password', 'formEditPassword');
$router->map('GET', '/delete/comment/[i:id]/[:token]', 'deleteComment');
$router->map('GET', '/published/comment/[i:id]/[i:published]/[:token]', 'setPublishedComment');//use post later is better

    // POST
$router->map('POST', '/editPassword', 'editPassword');
$router->map('POST', '/push/comment', 'pushComment');
$router->map('POST', '/deleteMember/[:token]', 'deleteMember');

// for user admin
    //--GET
$router->map('GET', '/push/post', 'formPushPost');
$router->map('GET', '/edit/post/[i:id]', 'formEditPost');
$router->map('GET', '/delete/post/[i:id]/[:token]', 'deletePost');

    //--POST
$router->map('POST', '/edit/post', 'editPost');
$router->map('POST', '/push/post', 'pushPost');

//END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===

// CALLED FUNCTIONS
function home()
{
    $blogSession = new BlogSession();
    MemberController::home($blogSession->getUser());
}

function home0()
{
    home();
}

function formContact()
{
    $blogSession = new BlogSession();
    ContactController::formContact($blogSession->getUser());
}

function sendMessage()
{
    if(isset($_POST['nom']) && isset( $_POST['mail']) &&  isset($_POST['contenu'] ))
    {
        ContactController::sendMessage($_POST['nom'], $_POST['mail'], $_POST['contenu']);
    }
}

// FOR POST
    //form
function formPushPost()
{
    $blogSession = new BlogSession();
    PostController::formPushPost($blogSession->getUser());
}

function formEditPost(String $id)
{
    $blogSession = new BlogSession();
    PostController::formEditPost($id, $blogSession->getUser());
}

    // controller need model
function post($slug)
{
    $blogSession = new BlogSession();
    PostController::get($slug, $blogSession->getUser());
}

function postBack($slug)
{
   $blogSession = new BlogSession();
    PostController::getBack($slug, $blogSession->getUser());
}

function posts()
{    $blogSession = new BlogSession();
    PostController::getAll($blogSession->getUser());
}

function postsBack()
{
   $blogSession = new BlogSession();
    PostController::getAllBack($blogSession->getUser());
}

function pushPost()
{
    if( isset($_POST['auteur']) && isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu']) && isset($_POST['token']))
    {
        $blogSession = new BlogSession();
        PostController::push($_POST['auteur'], $_POST['titre'], $_POST['chapo'],
        ($_POST['contenu']), $_POST['token'], $blogSession->getUser());
    }
    else
    {
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}

function editPost()
{
    if( isset($_POST['id']) && isset($_POST['auteur']) && isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu']) && isset($_POST['token']))
    {
        $blogSession = new BlogSession();
        PostController::edit($_POST['id'], $_POST['auteur'], $_POST['titre'], $_POST['chapo']
        , $_POST['contenu'] ,$_POST['token'], $blogSession->getUser());
    }
    else
    {
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}

function deletePost($id, $token)
{
    $blogSession = new BlogSession();
    PostController::delete($id, $token, $blogSession->getUser());
}

    //END POST===END POST===END POST===END POST===END POST===END POST===END POST===

    // FOR COMMENT

    // form

    // for user auth
function pushComment()
{
    if(isset($_POST['id_post']) && isset($_POST['contenu']) && isset($_POST['token']))
    {
        $blogSession = new BlogSession();
        CommentController::push($_POST['id_post'], $_POST['contenu'], $_POST['token'] ,$blogSession->getUser());
    }
}

function deleteComment($id, $token)
{
    $blogSession = new BlogSession();
    CommentController::delete($id, $token, $blogSession->getUser());   
}

// for user auth
function setPublishedComment($id, $published, $token)
{
    $blogSession = new BlogSession();
    CommentController::setPublished($id, $published, $token, $blogSession->getUser());
}


    // FOR MEMBER
        // form
function login()
{   
    MemberController::login();
}

function signUp()
{
    MemberController::signUp();
}

function pushMember()
{
    if(isset($_POST['login'], $_POST['password'] )){
        $blogSession = new BlogSession();
        MemberController::push($_POST['login'], $_POST['password'], $blogSession);
    }
}

function formEditPassword()
{
    $blogSession = new BlogSession();
    MemberController::formEditPassword($blogSession->getUser());
}

    //controller need model

function auth()
{
    if( isset($_POST['login'])  && isset($_POST['password']) )
    {
        $blogSession = new BlogSession();
        MemberController::auth($_POST['login'],    $_POST['password'] , $blogSession);
    }
    else
    {
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}

function disconnect()
{
    $blogSession = new BlogSession();
    MemberController::disconnect($blogSession);
}

function editPassword()
{
    if( isset($_POST['oldPassword'])  && isset($_POST['newPassword']) && isset($_POST['token']) )
    {
        $blogSession = new BlogSession();
        MemberController::editPassword($_POST['oldPassword'],  $_POST['newPassword'], $_POST['token'], $blogSession);
    }
    else
    {
        if(isset($_POST))
        {
            var_dump($_POST);
        }
        else{echo 'non';}
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}

function cv()
{
    MemberController::cv();
}

function administration()
{
    $blogSession = new BlogSession();
    MemberController::administration($blogSession->getUser());
}


    //END MEMBER===END MEMBER===END MEMBER===END MEMBER===END MEMBER===END MEMBER===

//END ALL CALL FUNCTIONS FOR ROUTER****************************************************

// match current request url
$match = $router->match();

// call closure or throw 404 status
// See Altorouter documentation:
// https://altorouter.com/usage/processing-requests.html
if( is_array($match))
{
    if( is_callable( $match['target'] ) ) 
    {
	    call_user_func_array( $match['target'], $match['params'] ); 
    }
     else 
     {
         echo "redirection pas de fonction de routage existante.";
     }
}
else
{
    $blogSession = new BlogSession();
    echo RedirectionController::getPage404($blogSession->getUser());
}