<?php

namespace Aniruddh\Router;

use Exception;

class Router{

    private $routes = [];
    private $callback404;

    public function add( $method, string $route, callable $callback ): void
    {
        try{
            $route = '#^' . $route . '$#';
            $method = empty($method) && is_array($method) ? ['GET'] : $method;
            if(!is_array($method)) {
                throw new Exception('Method must be array!');
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }
        $this->routes[] = [ $method, $route, $callback ];
    }

    public function run(): void
    {
        try {
            $requestUri = $this->getRequestUri();
            $requestMethod = $this->getRequestMethod();
            $args = [];
            foreach ($this->routes as $route) {
                if (in_array($requestMethod, $route[0])) {
                    if (preg_match($route[1], $requestUri)) {
                        $uriArray = explode('/', $requestUri);
                        $routeArray = explode('/', $route[1]);
                        $args = array_diff($uriArray, $routeArray );
                        unset($args[0]);
                        call_user_func_array($route[2], $args);
                        return;
                    }
                }
            }
            $this->error404();
        }catch(Exception $e) {
            echo $e->getMessage();
        } 
    }

    public static function getRequestUri(): string
    {
        return strtok($_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '/', '?');
    }

    public static function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ? $_SERVER['REQUEST_METHOD'] : 'GET';
    }

    public function set404(callable $callback): void
    {
        $this->callback404 = $callback;
    }

    public function error404(){
        http_response_code(404);
        if (! empty($this->callback404) ) {
            call_user_func_array($this->callback404, []) ;
        }else{
            echo "404 page not found!";
        }
    }

    
}
