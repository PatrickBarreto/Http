<?php

namespace Http\Routes;

use Closure;

class Route {
  
    public static array $post;

    public static array $get;

    public static array $put;
    
    public static array $patch;

    public static array $delete;

    /**
     * This method will prepare a POST route.
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function post(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        self::prepareRoute('POST', $endpoint,  $middlewares,  $controllerCallBack);
    }

    /**
     * This method will prepare a GET route.
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function get(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        self::prepareRoute('GET', $endpoint,  $middlewares,  $controllerCallBack);
    }

    /**
     * This method will prepare a PUT route.
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function put(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        self::prepareRoute('PUT', $endpoint,  $middlewares,  $controllerCallBack);
    }

    /**
     * This method will prepare a PATCH route.
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function patch(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        self::prepareRoute('PATCH', $endpoint,  $middlewares,  $controllerCallBack);
    }

    /**
     * This method will prepare a DELETE route.
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function delete(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        self::prepareRoute('DELETE', $endpoint,  $middlewares,  $controllerCallBack);
    }

    /**
     * This method will prepare the route by the format that the system will use
     * 
     * @param string $method
     * @param string $endpoint
     * @param array $middlewares
     * @param Closure $controllerCallBack
     * 
     * @return void
     */
    private static function prepareRoute(string $method, string $endpoint, array $middlewares, Closure $controllerCallBack){
        $endpoint = self::prepareEndpointRegex($endpoint);
        $propertySelfClass = strtolower($method);
        self::$$propertySelfClass[] = [
            "method" => $method,
            "endpoint" => '#^'.self::prepareEndpointRegex($endpoint).'$#',
            "middlewares" => $middlewares,
            "controller" => $controllerCallBack
        ];
    }

    /**
     * This method will prepare a POST route.
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return string
     */
    private static function prepareEndpointRegex(string $endpoint) {
        return preg_replace('/\{([^\}]+)\}/', '(?P<$1>[^/]+)', $endpoint);
    }

}