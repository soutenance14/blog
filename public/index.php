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
    //--GET
$router->map('GET', '/', 'home0');
$router->map('GET', '/home', 'home');
$router->map('GET', '/cv', 'cv');
$router->map('GET', '/admin_300', 'administration');
$router->map('GET', '/formContact', 'formContact');
$router->map('GET', '/signUp', 'signUp');
$router->map('GET', '/login', 'login');
$router->map('GET', '/posts', 'posts');
$router->map('GET', '/postsBack', 'postsBack');
// $router->map('GET', '/post/[i:id]', 'post');
// $router->map('GET', '/post/back/[i:id]', 'postBack');
$router->map('GET', '/post/[:slug]', 'post');
$router->map('GET', '/post/back/[:slug]', 'postBack');

    //--POST
$router->map('POST', '/auth', 'auth');
$router->map('POST', '/pushMember', 'pushMember');
$router->map('POST', '/sendMessage', 'sendMessage');

// for user auth
    //--GET
$router->map('GET', '/disconnect', 'disconnect');
$router->map('GET', '/formEditPassword', 'formEditPassword');
$router->map('GET', '/comm', 'formPushCommentASupprimer');// a supprimer, utiliser que pour les tests mais cest dans post que le formulaire sera
$router->map('GET', '/delete/comment/[i:id]/[:token]', 'deleteComment');
// $router->map('GET', '/formDeleteMember', 'formDeleteMember');
// $router->map('GET', '/formDeleteMemberBack', 'formDeleteMemberBack');
$router->map('GET', '/published/comment/[i:id]/[i:published]/[:token]', 'setPublishedComment');//use post later is better

    // POST
$router->map('POST', '/editPassword', 'editPassword');
$router->map('POST', '/push/comment', 'pushComment');
$router->map('POST', '/deleteMember/[:token]', 'deleteMember');

// for user admin
    //--GET
$router->map('GET', '/formPushPost', 'formPushPost');
$router->map('GET', '/form/edit/post/[i:id]', 'formEditPost');
// $router->map('GET', '/formDeletePost', 'formDeletePost');
$router->map('GET', '/delete/post/[i:id]/[:token]', 'deletePost');

    //--POST
$router->map('POST', '/editPost', 'editPost');
$router->map('POST', '/push/post', 'pushPost');
// $router->map('POST', '/deletePost', 'deletePost');

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
        PostController::push(htmlentities($_POST['auteur']), htmlentities($_POST['titre']), htmlentities($_POST['chapo']),
        htmlentities($_POST['contenu']), $_POST['token'], $blogSession->getUser());
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
        PostController::edit($_POST['id'], htmlentities($_POST['auteur']), htmlentities($_POST['titre']), htmlentities($_POST['chapo'])
        , htmlentities($_POST['contenu']) ,$_POST['token'], $blogSession->getUser());
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
        $blogSession = new BlogSession();
        CommentController::push($_POST['id_post'], htmlentities($_POST['contenu']), $_POST['token'] ,$blogSession->getUser());
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

function formDeleteMember()
{
    $blogSession = new BlogSession();   
    MemberController::formDelete($blogSession->getUser());
}

function formDeleteMemberBack()
{   
    $blogSession = new BlogSession();   
    MemberController::formDeleteBack($blogSession->getUser());
}

function deleteMember($token)
{
    if(isset($_POST['login'])   &&  isset($_POST['id'])    )
    {
        $blogSession = new BlogSession();
        MemberController::delete($_POST['login'], $_POST['id'] , $token, $blogSession);
    }
    
}

function pushMember()
{
    if(isset($_POST['login'], $_POST['password'] )){
        $blogSession = new BlogSession();
        MemberController::push(htmlentities($_POST['login']), htmlentities($_POST['password']), $blogSession);
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
        MemberController::editPassword(htmlentities($_POST['oldPassword']),  htmlentities($_POST['newPassword']), $_POST['token'], $blogSession);
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
    echo RedirectionController::getPage404();
}