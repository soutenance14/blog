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
$router->map('GET', '/login', 'login');
$router->map('GET', '/posts', 'posts');
$router->map('GET', '/post/[i:id]', 'post');
$router->map('GET', '/postBack/[i:id]', 'postBack');
// post
$router->map('POST', '/auth', 'auth');

// for user auth
//  get
$router->map('GET', '/disconnect', 'disconnect');
$router->map('GET', '/formEditPassword', 'formEditPassword');
$router->map('GET', '/comm', 'formPushCommentASupprimer');// a supprimer, utiliser que pour les tests mais cest dans post que le formulaire sera
$router->map('GET', '/deleteComment/[i:id]', 'deleteComment');
$router->map('GET', '/setPublishedComment/[i:id]/[i:published]', 'setPublishedComment');//use post later is better

// post
$router->map('POST', '/editPassword', 'editPassword');
$router->map('POST', '/pushComment', 'pushComment');

// for user admin
$router->map('GET', '/formPushPost', 'formPushPost');
$router->map('GET', '/formEditPost/[i:id]', 'formEditPost');
$router->map('GET', '/formDeletePost', 'formDeletePost');
// post
$router->map('POST', '/editPost', 'editPost');
$router->map('POST', '/pushPost', 'pushPost');
$router->map('POST', '/deletePost', 'deletePost');

//END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===END MAP ROUTES===

// CALLED FUNCTIONS
function home()
{
    echo "home";
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

//later, delete is from the getBack($id_post), the view give the link for form or just url
function formDeletePost()
{
    echo "formDeletePost";
    echo "<form action ='deletePost' method ='post'><input name='id'><input type='submit' name ='submit' value='ok'></form>";
}
    // controller need model
function post($id)
{
    // require  '../app/controller/PostController.php';
    PostController::get($id);
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

function pushPost()
{
    if( isset($_POST['auteur']) && isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu']) )
    {
        // require  '../app/controller/PostController.php';
        $blogSession = new BlogSession();
        PostController::push($_POST['auteur'], $_POST['titre'], $_POST['chapo'], $_POST['contenu'], $blogSession->getUser());
    }
    else
    {
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}

function editPost()
{
    if( isset($_POST['id']) && isset($_POST['auteur']) && isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu']) )
    {
        // require  '../app/controller/PostController.php';
        $blogSession = new BlogSession();
        PostController::edit($_POST['id'], $_POST['auteur'], $_POST['titre'], $_POST['chapo'], $_POST['contenu'], $blogSession->getUser());
    }
    else
    {
        // this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}

function deletePost()
{
    if( isset($_POST['id']) )
    {
        // require  '../app/controller/PostController.php';
        $blogSession = new BlogSession();
        PostController::delete($_POST['id'], $blogSession->getUser());
    }
    else
    {
        /// this call is not possible in theory
        echo 'problème, post(s) manquant(s).';
    }
}
    //END POST===END POST===END POST===END POST===END POST===END POST===END POST===

    // FOR COMMENT

    // form

function formPushCommentASupprimer()
{
    echo "formPushComment";
    echo "<form action ='pushComment' method ='post'><input name='id_post'><input name='contenu'><input type='submit' name ='submit' value='ok'></form>";
}

    // for user auth
function pushComment()
{
    if(isset($_POST['id_post']) && isset($_POST['contenu']) )
    {
        // require  '../app/controller/CommentController.php';
        $blogSession = new BlogSession();
        CommentController::push($_POST['id_post'], $_POST['contenu'], $blogSession->getUser());
    }
}

function deleteComment($id)
{
    // require  '../app/controller/CommentController.php';
    $blogSession = new BlogSession();
    CommentController::delete($id, $blogSession->getUser());   
}

// for user auth
function setPublishedComment($id, $published)
{
    // require  '../app/controller/CommentController.php';
    $blogSession = new BlogSession();
    CommentController::setPublished($id, $published, $blogSession->getUser());
}


    // FOR MEMBER
        // form
function login()
{
    // require  '../app/controller/MemberController.php';
    $blogSession = new BlogSession();
    MemberController::login();
}

function formEditPassword()
{
    // require  '../app/controller/MemberController.php';
    $blogSession = new BlogSession();
    MemberController::formEditPassword();
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