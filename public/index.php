<?php

require dirname(__DIR__) . '../vendor/autoload.php';

//start AltoRouter
$router = new AltoRouter();

// map routes
//$ router->map('TYPE', 'route', 'function')
// $router->map('GET', '/test/[*:test]/[*:test2]', 'test');

$router->map('GET', '/', 'home');
$router->map('GET', '/login', 'login');
// $router->map('GET', '/post', 'post');
$router->map('GET', '/member', 'member');

// $router->map('POST', '/login/[:login]/[:password]', 'authentication');
$router->map('POST', '/auth', 'auth');

// function test($id, $o)
// {
//     echo $id;
//     echo $o;
// }

function test()
{
    echo "test";
}

function home()
{
    echo "home";
}

function login()
{
    echo "login";
    echo "<form action ='auth' method ='post'><input name='login'><input name='password'><input type='submit' name ='submi' value='ok'></form>";
}

function post()
{
    echo "post";
}

function member()
{
    echo "member";
}

function auth()
{
    // le routeur n'assure pas la récupération des posts
    // uniquement le fait que le bon url est appelé que des éléments sont envoyés en POST
    if( isset($_POST['login'])  && isset($_POST['password']) )
    {
        require  '../app/controller/Controller.php';
        $controller = new Controller();
        $controller->auth($_POST['login'],    $_POST['password'] );
    }
    else{
        echo 'problème, post(s) manquant(s).';
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
         echo "pas de fonction existante";
     }
}
else{
    echo '404';
}