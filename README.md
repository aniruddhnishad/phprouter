PHPRoute - simple, lightweight, and fast router
=======================================

Install
-------

To install with composer:

```sh
composer require aniruddh/phprouter
```

Requires PHP 7.4 or newer.

Usage
-----

Here's a basic usage example:

```php
require_once('path/to/vendor/autoload.php');
use Aniruddh\Router\Router;
$router = new Router();
// default method is GET does not required to specify
$router->add('/', function() {
    echo 'get Home page';
});

$router->add('/test', function() {
    echo 'get test1';
});

$router->add('/test', function() {
    echo 'post test';
});

//you can specify if you want
$router->add('/test1', function() {
    echo 'get test1';
    
}, ['GET']);

//Except GET you have to specify the method
$router->add('/test1', function() {
    echo 'post test1';
}, ['POST']);

//you can specify multiple method
$router->add('/test2', function() {
    echo 'get and post test2';
}, ['GET', 'POST']);

//set 404 if not default 404 page shown
$router->set404(function(){
    echo "<h1>404 not found! </h1> url: " . htmlentities($_SERVER['REQUEST_URI']);
});
//run the router
$router->run();
```

### Defining routes

```php
//method and middleware must be an array
$route->add($route, $callback, $method, $middleware);
```


```php
//router use regex for route matching
// Matches /users/42, but not /users/abc
$router->add('/users/\d+', 'callback');
```

```php
// Example with middleware
$route->add('/users/\d+', 'callback', ['GET'], ['before'=> callabck, 'after'=> callback]);
```

```php
//Example with class object and method
$router->('/users', ['classname','method']);
```

```php
//Example with trailing slash option enable
require_once('path/to/vendor/autoload.php');

use Aniruddh\Router\Router;

$router = new Router(true, 1); //default is false and 0 // 0 means without trailing slash
// default method is GET does not required to specify
$router->add('/', function() {
    echo 'get Home page';
});
$router->('/users', callback); //use can specify route like $router->('users', callback); both version will work
```

## Note
coming soon...