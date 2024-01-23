<?php 

namespace Http;

use Http\Middleware\Middleware;
use Http\Request\Request;
use Http\Router\Router;
use Http\Routes\Route;
use Http\Response\Response;
use Closure;
use Http\Cors\Cors;

final class Http {

    /**
     * This method will manage the Route Class with methods POST
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function post(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        Route::post($endpoint, $controllerCallBack, $middlewares);
    }

    /**
     * This method will manage the Route Class with methods GET
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function get(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        Route::get($endpoint, $controllerCallBack, $middlewares);
    }

    /**
     * This method will manage the Route Class with methods PUT
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function put(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        Route::put($endpoint, $controllerCallBack, $middlewares);
    }

    /**
     * This method will manage the Route Class with methods PATCH
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function patch(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        Route::patch($endpoint, $controllerCallBack, $middlewares);
    }

    /**
     * This method will manage the Route Class with methods DELETE
     * 
     * @param string $endpoint
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function delete(string $endpoint, Closure $controllerCallBack, array $middlewares = []) {
        Route::delete($endpoint, $controllerCallBack, $middlewares);
    }

    /**
     * This method will manage the Middleware Class to add the Middleware Routes Map
     * 
     * @param string $name
     * @param string $namespace, 
     * @param bool $defaultForAllRoutes
     * 
     * @return void
     */
    public static function middleware(string $name, string $namespace, bool $defaultForAllRoutes = false) {
        Middleware::add($name, $namespace, $defaultForAllRoutes);
    }

    /**
     * This method will manage the Response Class. 
     * Important: Do not send a json string as response. It will be interpreted like a normal string.
     * 
     * @param array|string|object|int $response
     * @param Closure $controllerCallBack, 
     * @param array $middlewares
     * 
     * @return void
     */
    public static function response($response = ['success'=>true],  int $statusCode = 200, array $headers = ["Content-Type" => "application/json"]) {
        if(!is_array($response)) { 
            $response = (array)$response;
        }
        Response::exec($response, $statusCode, $headers);
    }

    /**
     * This method will make CORS config
     * 
     * @param array $accessControlAllowOrigin
     * @param array $accessControlAllowMethods
     * @param array $accessControlAllowHeaders
     * @param array $accessControlAllowCredentials
     * @param array $accessControlExposeHeaders
     * @param array $accessControlMaxAge
     * 
     * @return void
     */
    public static function CORS(array $accessControlAllowOrigin = ['*'], 
                                array $accessControlAllowMethods = ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                                array $accessControlAllowHeaders = ['Content-Type'],
                                bool $accessControlAllowCredentials = false,
                                array $accessControlExposeHeaders = ['Content-Type'],
                                int $accessControlMaxAge = 86400){

        Cors::enableCORS(
                        $accessControlAllowOrigin, $accessControlAllowMethods, $accessControlAllowHeaders, 
                        $accessControlAllowCredentials, $accessControlExposeHeaders, $accessControlMaxAge
                        );
    }

    /**
     * This method will run the app, finding the matched between the requested route and the list of routes controller. 
     * 
     * @return void
     */
    public static function run(){
        Request::setData();
        Router::findMatch();
    }

}