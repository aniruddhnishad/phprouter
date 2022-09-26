<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Aniruddh\Router\Router;

$router = new Router();

$router->add('/', function() {

    echo 'get Home page';
});

$router->add('/test', function() {

    echo 'get test1';
});

$router->add('/test', function() {

    echo 'post test';
});

$router->add('/test1', function() {

    echo 'get test1';
});

$router->add('/test1', function() {

    echo 'post test1';
});

$router->add('/test2', function() {

    echo 'get and post test2';
}, ['GET', 'POST']);

$router->set404(function(){
    echo "<h1>404 not found! </h1> url: " . htmlentities($_SERVER['REQUEST_URI']);
});

$router->run();