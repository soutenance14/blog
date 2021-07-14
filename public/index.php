<?php

// This is the router page

require dirname(__DIR__) . '../vendor/autoload.php';

//start AltoRouter
$router = new AltoRouter();

// map routes

// user no auth
// get
$router->map('GET', '/', 'home');
$router->map('GET', '/login', 'login');
$router->map('GET', '/posts', 'posts');
$router->map('GET', '/post/[i:id]', 'post');
// post
$router->map('POST', '/auth', 'auth');

// user auth
//  get
$router->map('GET', '/formEditPassword', 'formEditPassword');

// post
$router->map('POST', '/editPassword', 'editPassword');

// user admin
$router->map('GET', '/formPushPost', 'formPushPost');
$router->map('GET', '/formEditPost', 'formEditPost');
$router->map('GET', '/formDeletePost', 'formDeletePost');
// post
$router->map('POST', '/editPost', 'editPost');
$router->map('POST', '/pushPost', 'pushPost');
$router->map('POST', '/deletePost', 'deletePost');

// Functions for call controller functions
function home()
{
    echo "home";
}

//for post
//form
function formPushPost()
{
    echo "formPushPost";
    echo "<form action ='pushPost' method ='post'><input name='auteur'><input name='titre'><input name='chapo'><input name='contenu'><input type='submit' name ='submit' value='ok'></form>";
}

function formEditPost()
{
    echo "formEditPost";
    echo "<form action ='editPost' method ='post'><input name='id'><input name='auteur'><input name='titre'><input name='chapo'><input name='contenu'><input type='submit' name ='submit' value='ok'></form>";
}

function formDeletePost()
{
    echo "formDeletePost";
    echo "<form action ='deletePost' method ='post'><input name='id'><input type='submit' name ='submit' value='ok'></form>";
}

function post($id)
{
    try 
    {
        require  '../app/controller/PostController.php';
        PostController::get($id);
    } 
    catch (\PDOException $e)
    {
        // throw new \PDOException($e->getMessage(), (int)$e->getCode());
        redirectionIfPDOException($e);
    }
}

function posts()
{
    try 
    {
        require  '../app/controller/PostController.php';
        PostController::getAll();
    } 
    catch (\PDOException $e)
    {
        // throw new \PDOException($e->getMessage(), (int)$e->getCode());
        redirectionIfPDOException($e);
    }
}

function pushPost()
{
    if( isset($_POST['auteur']) && isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu']) )
    {
        try 
        {
            require  '../app/controller/PostController.php';
            PostController::push($_POST['auteur'], $_POST['titre'], $_POST['chapo'], $_POST['contenu']);
        } 
        catch (\PDOException $e)
        {
            // throw new \PDOException($e->getMessage(), (int)$e->getCode());
            redirectionIfPDOException($e);
        }
    }
    else
    {
        // a changer redirect view ici
        echo 'problème, post(s) manquant(s).';
    }
}

function editPost()
{
    if( isset($_POST['id']) && isset($_POST['auteur']) && isset($_POST['titre']) && isset($_POST['chapo']) && isset($_POST['contenu']) )
    {
        try 
        {
            require  '../app/controller/PostController.php';
            PostController::edit($_POST['id'], $_POST['auteur'], $_POST['titre'], $_POST['chapo'], $_POST['contenu']);
        } 
        catch (\PDOException $e)
        {
            // throw new \PDOException($e->getMessage(), (int)$e->getCode());
            redirectionIfPDOException($e);
        }
    }
    else
    {
        // a changer redirect view ici
        echo 'problème, post(s) manquant(s).';
    }
}

function deletePost()
{
    if( isset($_POST['id']) )
    {
        try 
        {
            require  '../app/controller/PostController.php';
            PostController::delete($_POST['id']);
        } 
        catch (\PDOException $e)
        {
            // throw new \PDOException($e->getMessage(), (int)$e->getCode());
            redirectionIfPDOException($e);
        }
    }
    else
    {
        // a changer redirect view ici
        echo 'problème, post(s) manquant(s).';
    }
}



    // for member 
        // form
function login()
{
    echo "login";
    echo "<form action ='auth' method ='post'><input name='login'><input name='password'><input type='submit' name ='submi' value='ok'></form>";
}

function formEditPassword()
{
    echo "formEditPassword";
    echo "<form action ='editPassword' method ='post'><input name='oldPassword'><input name='newPassword'><input name='confirmNewPassword'><input type='submit' name ='submit' value='ok'></form>";
}

        //link with db

function auth()
{
    if( isset($_POST['login'])  && isset($_POST['password']) )
    {
        try 
        {
            require  '../app/controller/MemberController.php';
            MemberController::auth($_POST['login'],    $_POST['password'] );
        } 
        catch (\PDOException $e)
        {
            // throw new \PDOException($e->getMessage(), (int)$e->getCode());
            redirectionIfPDOException($e);
        }
    }
    else
    {
        // a changer redirect view ici
        echo 'problème, post(s) manquant(s).';
    }
}

function editPassword()
{
    // remplacer les Get par des Post apres
    if( isset($_POST['oldPassword'])  && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword']) )
    {
        try 
        {
            require  '../app/controller/MemberController.php';
            MemberController::editPassword($_POST['oldPassword'],  $_POST['newPassword'],  $_POST['confirmNewPassword']);
        } 
        catch (\PDOException $e)
        {
            // throw new \PDOException($e->getMessage(), (int)$e->getCode());
            redirectionIfPDOException($e);
        }
    }
    else
    {
        // a changer redirect view ici
        echo 'problème, post(s) manquant(s).';
    }
}

//redirection view if pb with db
function redirectionIfPDOException(\PDOException $e)
{
    switch($e->getCode())
    {
        case '1049':
            echo 'redirection pb avec la db: connexion impossible à la db.' , $e->getCode(), $e->getMessage();
            break;    
        case '42S22':
            echo 'redirection pb avec la db: impossible de récupérer les données d\'une colonne.' , $e->getCode(), $e->getMessage();
            break;    
        case '42S02':
            echo 'redirection pb avec la db: impossible de se connecter à une table.' , $e->getCode(), $e->getMessage();
            break;    
        case '42000':
            echo 'redirection pb avec la db: erreur de syntaxe.' , $e->getCode(), $e->getMessage();
            break;
        default:
            echo 'redirection pb avec la db: une erreur inatendue est arrivé avec la db.';
            throw new \PDOException($e->getMessage(), (int)$e->getCode());  
    }
}

// match current request url
$match = $router->match();

// call closure or throw 404 status
if( is_array($match))
{
    if( is_callable( $match['target'] ) ) {
    
	    call_user_func_array( $match['target'], $match['params'] ); 
    }
     else 
     {
         echo "redirection pas de fonction de routage existante.";
     }
}
else{
    echo '404';
}