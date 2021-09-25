<?php


// This is the router page
// use package Altorouter
// https://altorouter.com

use App\Controller\CommentController;
use App\Controller\ContactController;
use App\Controller\MemberController;
use App\Controller\PostController;
use App\Controller\RedirectionController;
use App\Session\BlogHttp;

// use App\Session\BlogHttp;

require_once dirname(__DIR__).'../vendor/autoload.php';

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
    $BlogHttp = new BlogHttp();
    print_r(MemberController::home($BlogHttp->getUser()));
}

function home0()
{
    home();
}

function formContact()
{
    $BlogHttp = new BlogHttp();
    print_r(ContactController::formContact($BlogHttp->getUser()));
}

function sendMessage()
{
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if(isset($post['nom']) && isset( $post['mail']) &&  isset($post['contenu'] ))
    {
        print_r(ContactController::sendMessage($post['nom'], $post['mail'], $post['contenu']));
    }
}

// FOR POST
    //form
function formPushPost()
{
    $BlogHttp = new BlogHttp();
    print_r(PostController::formPushPost($BlogHttp->getUser()));
}

function formEditPost(String $id)
{
    $BlogHttp = new BlogHttp();
    print_r(PostController::formEditPost($id, $BlogHttp->getUser()));
}

    // controller need model
function post($slug)
{
    $BlogHttp = new BlogHttp();
    print_r(PostController::get($slug, $BlogHttp->getUser()));
}

function postBack($slug)
{
   $BlogHttp = new BlogHttp();
    print_r(PostController::getBack($slug, $BlogHttp->getUser()));
}

function posts()
{    $BlogHttp = new BlogHttp();
    print_r(PostController::getAll($BlogHttp->getUser()));
}

function postsBack()
{
   $BlogHttp = new BlogHttp();
    print_r(PostController::getAllBack($BlogHttp->getUser()));
}

function pushPost()
{
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if( isset($post['auteur']) && isset($post['titre']) && isset($post['chapo']) && isset($post['contenu']) && isset($post['token']))
    {
        $BlogHttp = new BlogHttp();
        print_r(PostController::push($post['auteur'], $post['titre'], $post['chapo'],
        ($post['contenu']), $post['token'], $BlogHttp->getUser()));
    }
    else
    {
        // this call is not possible in theory
        print_r('problème, post(s) manquant(s).');
    }
}

function editPost()
{
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if( isset($post['id']) && isset($post['auteur']) && isset($post['titre']) && isset($post['chapo']) && isset($post['contenu']) && isset($post['token']))
    {
        $BlogHttp = new BlogHttp();
        print_r(PostController::edit($post['id'], $post['auteur'], $post['titre'], $post['chapo']
        , $post['contenu'] ,$post['token'], $BlogHttp->getUser()));
    }
    else
    {
        // this call is not possible in theory
        print_r('problème, post(s) manquant(s).');
    }
}

function deletePost($id, $token)
{
    $BlogHttp = new BlogHttp();
    print_r(PostController::delete($id, $token, $BlogHttp->getUser()));
}

    //END POST===END POST===END POST===END POST===END POST===END POST===END POST===

    // FOR COMMENT

    // form

    // for user auth
function pushComment()
{
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if(isset($post['id_post']) && isset($post['contenu']) && isset($post['token']))
    {
        $BlogHttp = new BlogHttp();
        print_r(CommentController::push($post['id_post'], $post['contenu'], $post['token'] ,$BlogHttp->getUser()));
    }
}

function deleteComment($id, $token)
{
    $BlogHttp = new BlogHttp();
    print_r(CommentController::delete($id, $token, $BlogHttp->getUser()));   
}

// for user auth
function setPublishedComment($id, $published, $token)
{
    $BlogHttp = new BlogHttp();
    print_r(CommentController::setPublished($id, $published, $token, $BlogHttp->getUser()));
}


    // FOR MEMBER
        // form
function login()
{   
    print_r(MemberController::login());
}

function signUp()
{
    print_r(MemberController::signUp());
}

function pushMember()
{
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if(isset($post['login'], $post['password'] )){
        $BlogHttp = new BlogHttp();
        print_r(MemberController::push($post['login'], $post['password'], $BlogHttp));
    }
}

function formEditPassword()
{
    $BlogHttp = new BlogHttp();
    print_r(MemberController::formEditPassword($BlogHttp->getUser()));
}

    //controller need model

function auth()
{
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if( isset($post['login'])  && isset($post['password']) )
    {
        $BlogHttp = new BlogHttp();
        print_r(MemberController::auth($post['login'],    $post['password'] , $BlogHttp));
    }
    else
    {
        // this call is not possible in theory
        print_r('problème, post(s) manquant(s).');
    }
}

function disconnect()
{
    $BlogHttp = new BlogHttp();
    print_r(MemberController::disconnect($BlogHttp));
}

function editPassword()
{
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if( isset($post['oldPassword'])  && isset($post['newPassword']) && isset($post['token']) )
    {
        $BlogHttp = new BlogHttp();
        print_r(MemberController::editPassword($post['oldPassword'],  $post['newPassword'], $post['token'], $BlogHttp));
    }
    else
    {
        // this call is not possible in theory
        print_r('problème, post(s) manquant(s).');
    }
}

function getCV()
{
    print_r(MemberController::getCV());
}

function administration()
{
    $BlogHttp = new BlogHttp();
    print_r(MemberController::administration($BlogHttp->getUser()));
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
         print_r("redirection pas de fonction de routage existante.");
     }
}
else
{
    $BlogHttp = new BlogHttp();
    print_r(print_r(RedirectionController::getPage404($BlogHttp->getUser())));
}