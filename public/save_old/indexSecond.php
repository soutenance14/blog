<?php

$route = ['home','post','member'];

// require dirname(__DIR__) . "../vendor/autoload.php";
//get
if(isset($_GET['url'])){
    $controllerPage = $_GET['url'];
    if(in_array($controllerPage, $route))
    {
        require "../controller/Controller.php";
        $controller = new Controller();
        $controller->$controllerPage();
    }
    else{
        echo "404 url non trouvé";
    }
}
//post
elseif(!empty($_POST)){

    echo "post";
}
else{
    echo '404';
}