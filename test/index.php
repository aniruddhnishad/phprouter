<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Aniruddh\Router\Router;

$router = new Router();

$router->add(['GET'], '/', function() {

    echo 'get Home page';
});

$router->add([], '/test', function() {

    echo 'get test1';
});

$router->add(['POST'], '/test', function() {

    echo 'post test';
});

$router->add(['GET'], '/test1', function() {

    echo 'get test1';
});

$router->add(['POST'], '/test1', function() {

    echo 'post test1';
});

$router->add(['GET', 'POST'], '/test2', function() {

    echo 'get and post test2';
});

$router->set404(function(){
    echo "<h1>404 not found! </h1> url: " . htmlentities($_SERVER['REQUEST_URI']);
});
$router->run();