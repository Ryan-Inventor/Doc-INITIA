<?php

class Router {
    protected $routes = [];

    /**
     * Add a GET route
     */
    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Add a POST route
     */
    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Load the requested route
     */
    public function dispatch($uri) {
        // Strip query string
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        
        $method = $_SERVER['REQUEST_METHOD'];

        // Check for direct match
        if (array_key_exists($uri, $this->routes[$method])) {
            $this->callAction($this->routes[$method][$uri]);
            return;
        }

        // Check for dynamic routes (regex)
        foreach ($this->routes[$method] as $route => $controller) {
            // Convert route to regex: users/{id} -> users/(\d+)
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route);
            $pattern = "@^" . $pattern . "$@D";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                $this->callAction($controller, $matches);
                return;
            }
        }

        $this->abort(404);
    }

    /**
     * Call the controller action
     */
    protected function callAction($controllerAction, $params = []) {
        list($controllerName, $method) = explode('@', $controllerAction);
        
        require_once __DIR__ . "/controllers/{$controllerName}.php";
        $controller = new $controllerName();
        
        if (!method_exists($controller, $method)) {
            throw new Exception("Method $method not found in controller $controllerName");
        }

        call_user_func_array([$controller, $method], $params);
    }

    protected function abort($code) {
        http_response_code($code);
        require __DIR__ . "/views/errors/{$code}.php";
        exit;
    }
}
