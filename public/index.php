<?php

// This is the router page
// use package Altorouter
// https://altorouter.com

use App\Controller\CommentController;
use App\Controller\ContactController;
use App\Controller\MemberController;
use App\Controller\PostController;
use App\Controller\RedirectionController;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'../vendor/autoload.php';

//start AltoRouter
$router = new AltoRouter();

// ALL MAP ROUTES

// for user no auth
    //--GET
$router->map('GET', '/', 'home0');
$router->map('GET', '/home', 'home');
$router->map('GET', '/cv', 'getCV');
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
$router->map('POST', '/edit/password', 'editPassword');
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
    print_r(MemberController::home());
}

function home0()
{
    home();
}

function formContact()
{
    print_r(ContactController::formContact());
}

function sendMessage()
{
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $request = Request::createFromGlobals();;
    print_r( ContactController::sendMessage($request));
}

// FOR POST
    //form
function formPushPost()
{    
    print_r(PostController::formPushPost());
}

function formEditPost(String $id)
{   
    print_r(PostController::formEditPost($id));
}

    // controller need model
function post($slug)
{   
    print_r(PostController::get($slug));
}

function postBack($slug)
{  
    print_r(PostController::getBack($slug));
}

function posts()
{    
    print_r(PostController::getAll());
}

function postsBack()
{
    print_r(PostController::getAllBack());
}

function pushPost()
{
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $request = Request::createFromGlobals();
    print_r(PostController::push($request));
}

function editPost()
{
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $request = Request::createFromGlobals();;
    print_r( PostController::edit($request));
}

function deletePost($id, $token)
{
    print_r(PostController::delete($id, $token));
}

    //END POST===END POST===END POST===END POST===END POST===END POST===END POST===

    // FOR COMMENT

    // form

    // for user auth
function pushComment()
{
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $request = Request::createFromGlobals();;
    print_r((CommentController::push($request )));
    
}

function deleteComment($id, $token)
{
    print_r(CommentController::delete($id, $token));   
}

// for user auth
function setPublishedComment($id, $published, $token)
{
    print_r(CommentController::setPublished($id, $published, $token));
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
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $request = Request::createFromGlobals();;
    print_r(MemberController::push($request));
}

function formEditPassword()
{
    print_r(MemberController::formEditPassword());
}

    //controller need model

function auth()
{
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $request = Request::createFromGlobals();;
    print_r(MemberController::auth($request));
}

function disconnect()
{
    print_r(MemberController::disconnect());
}

function editPassword()
{
    // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $request = Request::createFromGlobals();
    print_r(MemberController::editPassword($request));
}

function getCV()
{
    print_r(MemberController::getCV());
}

function administration()
{
    print_r(MemberController::administration());
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
    {   //if fucntion exists and is callabe
	    call_user_func_array( $match['target'], $match['params'] ); 
    }
    else 
    {
        print_r(RedirectionController::getPageNoFuncCallable());
    }
}
else
{
    print_r(print_r(RedirectionController::getPage404()));
}