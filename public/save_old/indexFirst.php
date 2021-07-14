<?php

require dirname(__DIR__) . '../vendor/autoload.php';

//start AltoRouter
$router = new AltoRouter();

// map routes
$router->map('GET', '/', 'home');
$router->map('GET', '/users/[*:test]/[*:test2]', 'test');

function test($id, $o)
{
    echo $id;
    echo $o;
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
        $target = $match['target'];
        //match target with view
        echo 'target : ', $target;
     }
}
else{
    echo '404';
}