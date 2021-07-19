<?php


// This is the router page
// use package Altorouter
// https://altorouter.com

require dirname(__DIR__) . '../vendor/autoload.php';
require dirname(__DIR__) . '../app/BlogSession.php';

//start AltoRouter
$router = new AltoRouter();


// ALL MAP ROUTES

// for user no auth
// get
$router->map('GET', '/', 'home');
$router->map('GET', '/formContact', 'formContact');
$router->map('GET', '/signUp', 'signUp');
$router->map('GET', '/login', 'login');
$router->map('GET', '/posts', 'posts');
$router->map('GET', '/postsBack', 'postsBack');
$router->map('GET', '/post/[i:id]', 'post');
$router->map('GET', '/postBack/[i:id]', 'postBack');

// post
$router->map('POST', '/auth', 'auth');
$router->map('POST', '/pushMember', 'pushMember');

// for user auth
//  get
$router->map('GET', '/disconnect', 'disconnect');
$router->map('GET', '/formEditPassword', 'formEditPassword');
$router->map('GET', '/comm', 'formPushCommentASupprimer');// a supprimer, utiliser que pour les tests mais cest dans post que le formulaire sera
$router->map('GET', '/deleteComment/[i:id]/[:token]', 'deleteComment');
$router->map('GET', '/setPublishedComment/[i:id]/[i:published]/[:token]', 'setPublishedComment');//use post later is better

// post
//contact
$router->map('POST', '/sendMessage', 'sendMessage');

$router->map('POST', '/editPassword', 'editPassword');
$router->map('POST', '/pushComment', 'pushComment');

// for user admin
$router->map('GET', '/formPushPost', 'formPushPost');
$router->map('GET', '/formEditPost/[i:id]/[:token]', 'formEditPost');
$router->map('GET', '/formDeletePost', 'formDeletePost');
$router->map('GET', '/deletePost/[i:id]/[:token]', 'deletePost');
// post
$router->map('POST', '/editPost', 'editPost');
$router->map('POST', '/pushPost', 'pushPost');
// $router->map('POST', '/deletePost', 'deletePost');

//END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===

// CALLED FUNCTIONS
function home()
{
    PostController::home();
}

function formContact()
{
    ContactController::formContact();
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
    // require  '../app/controller/PostController.php';
    $blogSession = new BlogSession();
    PostController::formPushPost($blogSession->getUser());
}

function formEditPost(String $id)
{
    // require  '../app/controller/PostController.php';
    $blogSession = new BlogSession();
    PostController::formEditPost($id, $blogSession->getUser());
}

    // controller need model
function post($id)
{
    // require  '../app/controller/PostController.php';
    $blogSession = new BlogSession();
    PostController::get($id, $blogSession->getUser());
}

function postBack($id)
{
    // require  '../app/controller/PostController.php';
    $blogSession = new BlogSession();
    PostController::getBack($id, $blogSession->getUser());
}

function posts()
{
    // require  '../app/controller/PostController.php';
    PostController::getAll();
}

function postsBack()
{
    // require  '../app/controller/PostController.php';
    $blogSession = new BlogSession();
    PostController::getAllBack($blogSession->getUser());
}

function pushPost()
{
    if( isset($_POST['auteur']) && isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu']) && isset($_POST['token']))
    {
        // require  '../app/controller/PostController.php';
        $blogSession = new BlogSession();
        PostController::push($_POST['auteur'], $_POST['titre'], $_POST['chapo'], $_POST['contenu'], $_POST['token'], $blogSession->getUser());
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
        // require  '../app/controller/PostController.php';
        $blogSession = new BlogSession();
        PostController::edit($_POST['id'], $_POST['auteur'], $_POST['titre'], $_POST['chapo'], $_POST['contenu'] ,$_POST['token'], $blogSession->getUser());
    }
    else
    {
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}

function deletePost($id, $token)
{
    // require  '../app/controller/PostController.php';
    $blogSession = new BlogSession();
    PostController::delete($id, $token, $blogSession->getUser());
}


    //END POST===END POST===END POST===END POST===END POST===END POST===END POST===

    // FOR COMMENT

    // form

function formPushCommentASupprimer()
{
    $blogSession = new BlogSession();
    echo "formPushComment";
    echo "<form action ='pushComment' method ='post'><input name='id_post'><input name='contenu'><input type='submit' name ='submit' value='ok'>
    <input name='token' value='".$blogSession->getUser()->getToken()."'>
    </form>";
}

    // for user auth
function pushComment()
{
    if(isset($_POST['id_post']) && isset($_POST['contenu']) && isset($_POST['token']))
    {
        // require  '../app/controller/CommentController.php';
        $blogSession = new BlogSession();
        CommentController::push($_POST['id_post'], $_POST['contenu'], $_POST['token'] ,$blogSession->getUser());
    }
}

function deleteComment($id, $token)
{
    // require  '../app/controller/CommentController.php';
    $blogSession = new BlogSession();
    CommentController::delete($id, $token, $blogSession->getUser());   
}

// for user auth
function setPublishedComment($id, $published, $token)
{
    // require  '../app/controller/CommentController.php';
    $blogSession = new BlogSession();
    CommentController::setPublished($id, $published, $token, $blogSession->getUser());
}


    // FOR MEMBER
        // form
function login()
{
    // require  '../app/controller/MemberController.php';
    MemberController::login();
}

function signUp()
{
    // require  '../app/controller/MemberController.php';
    MemberController::signUp();
}

function pushMember()
{
    if(isset($_POST['login'], $_POST['password'] )){
        $blogSession = new BlogSession();
        // require  '../app/controller/MemberController.php';
        MemberController::pushMember($_POST['login'], $_POST['password'], $blogSession);
    }
}

function formEditPassword()
{
    // require  '../app/controller/MemberController.php';
    $blogSession = new BlogSession();
    MemberController::formEditPassword($blogSession->getUser());
}

    //controller need model

function auth()
{
    if( isset($_POST['login'])  && isset($_POST['password']) )
    {
        // require  '../app/controller/MemberController.php';
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
    // require  '../app/controller/MemberController.php';
    $blogSession = new BlogSession();
    MemberController::disconnect($blogSession);
}

function editPassword()
{
    if( isset($_POST['oldPassword'])  && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword']) )
    {
        // require  '../app/controller/MemberController.php';
        $blogSession = new BlogSession();
        MemberController::editPassword($_POST['oldPassword'],  $_POST['newPassword'],  $_POST['confirmNewPassword'], $blogSession->getUser());
    }
    else
    {
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
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
    echo '404 Redirection';
}