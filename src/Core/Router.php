<?php

/*namespace App\Core;

class Router {
    private $routes = [];

    public function add($path, $callback, $method = 'GET', $middleware = []) {
        $this->routes[$method][$path] = ['callback' => $callback, 'middleware' => $middleware];
    }

    public function dispatch() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$url])) {
            $route = $this->routes[$method][$url];
            $middleware = $route['middleware'];

            foreach($middleware as $mw){
                if (is_callable($mw)) {
                    call_user_func($mw);
                } else if (is_array($mw) && count($mw) == 2) {
                    list($class, $method) = $mw;
                    if (class_exists($class) && method_exists($class, $method)) {
                        call_user_func([$class, $method]);
                    }
                }
            }

            $callback = $route['callback'];
            if (is_callable($callback)) {
                call_user_func($callback);
            } else if (is_string($callback)) {
                $this->callController($callback);
            }
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    private function callController($callback) {
        list($controller, $method) = explode('@', $callback);
        $controller = "App\\Controllers\\$controller";
        if (class_exists($controller)) {
            $controller = new $controller();
            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                http_response_code(404);
                echo "404 Method Not Found";
            }
        } else {
            http_response_code(404);
            echo "404 Controller Not Found";
        }
    }
}*/

namespace App\Core;

class Router {
    private $routes = [];

    public function add($path, $callback, $method = 'GET', $middleware = []) {
        $this->routes[$method][$path] = ['callback' => $callback, 'middleware' => $middleware];
    }

    public function dispatch() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $route => $data) {
            $pattern = "@^" . preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9-_]+)', $route) . "$@D";
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                $middleware = $data['middleware'];

                foreach($middleware as $mw) {
                    if (is_callable($mw)) {
                        call_user_func($mw);
                    } else if (is_array($mw) && count($mw) == 2) {
                        list($class, $method) = $mw;
                        if (class_exists($class) && method_exists($class, $method)) {
                            call_user_func([$class, $method]);
                        }
                    }
                }

                $callback = $data['callback'];
                if (is_callable($callback)) {
                    call_user_func_array($callback, $matches);
                } else if (is_string($callback)) {
                    $this->callController($callback, $matches);
                }
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function callController($callback, $params) {
        list($controller, $method) = explode('@', $callback);
        $controller = "App\\Controllers\\$controller";
        if (class_exists($controller)) {
            $controller = new $controller();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                http_response_code(404);
                echo "404 Method Not Found";
            }
        } else {
            http_response_code(404);
            echo "404 Controller Not Found";
        }
    }
}
