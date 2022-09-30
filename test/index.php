<?php
/*
require_once(__DIR__ . '/../src/Router.php');

use Aniruddh\Router\Router;

$router = new Router(true, 1);

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

$router->add('/test3', function() {

    echo 'get and post test3';
}, ['GET', 'POST'], ['before' =>function(){echo "before";}, 'after' => function(){echo "after";}]);


$router->run();
*/