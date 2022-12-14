<?php
namespace Aniruddh\Router;

use Exception;

class Router {

    protected $routes;
    protected $callback404;
    protected $trailingSlash;
    protected $mode;

    public function __construct($trailingSlash = false, $mode = 0)
    {
        $this->trailingSlash = $trailingSlash;
        $this->mode = $mode;
    }

    public function add( string $route, callable $callback, $method = [], $middleware = [] ): void {
        try {
            $route = '#^' . trim($route, '/') . '$#i';
            $method = empty($method) && is_array($method) ? ['GET'] : array_flip(array_change_key_case(array_flip($method), CASE_UPPER));
            if( !is_array($method) ) {
                throw new Exception('Method must be an array!');
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }
        $this->routes[] = [ $route, $callback, $method, $middleware ];
    }

    public function run(): void {
        try{
            $requestUrl = $this->getUrl() == '' ? '/' : $this->getUrl();
            $requestMethod = $this->getMethod();
            foreach( $this->routes as $route ) {
                if( in_array($requestMethod, $route[2]) )  {
                    $route[0] = $route[0] = '' ? '/' : $route[0];
                    if( preg_match($route[0], $requestUrl) ) {
                        if( in_array($route[3], $route) && is_array($route[3]) ) {
                            if( array_key_exists('before', $route[3]) && is_callable($route[3]['before'])  ) {
                                call_user_func_array($route[3]['before'], []);
                                }
                                $urlArray = explode('/', $requestUrl);
                                $routeArray = explode('/', $route[0]);
                                $args = array_diff($urlArray, $routeArray);
                                unset($args[0]);
                                call_user_func_array($route[1], $args);
                                if( array_key_exists('after', $route[3]) && is_callable($route[3]['after']) ) {
                                    call_user_func_array($route[3]['after'], []);
                                    }
                                return;
                        }
                        $urlArray = explode('/', $requestUrl);
                        $routeArray = explode('/', $route[0]);
                        $args = array_diff($urlArray, $routeArray);
                        unset($args[0]);
                        call_user_func_array($route[1], $args);
                        return;
                    }
                }
            }
            $this->error404();
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    function getUrl() {
        if($this->trailingSlash) {
            $url = $this->mode ? $this->trailingSlash() : $this->noTrailingSlash();
            return trim($url, '/');
        }else{
            return trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
        }
    }

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function redirect($scheme, $url) {
        http_response_code($scheme);
        header("Location: $url");
        exit();
    }

    public function noTrailingSlash() {
        $url = strtok($_SERVER['REQUEST_URI'], '?');
        if(substr($url, -1) == '/') {
            $url = trim($url, '/');
            $url = $url !== '' ? $this->redirect(301, '/' . $url) : $url;
        }
        return $url;
    }

    public function trailingSlash() {
        $url = strtok($_SERVER['REQUEST_URI'], '?');
        if(substr($url, -1) !== '/') {
            $url = trim($url, '/');
            $url = $url !== '' ? $this->redirect(301, '/' . $url . '/') : $url;
        }
        return $url;
    }

    public function set404($callback): void {
        $this->callback404 = $callback;
    }

    public function error404() {
        http_response_code(404);
        if( !empty($this->callback404) ) {
            call_user_func_array($this->callback404, []);
        }else {
            echo "404 Page Not Found!";
        }
    }
}