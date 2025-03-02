<?php

namespace Http\Router;

use Exception\Exception;
use Http\Request\Request;
use Http\Routes\Route;
use Http\Router\Queue\Queue;


class Router {

    /**
     * This method gonna find the route data that match with the request regex URI
     *
     * @param Request $request
     * @return void
     */
    public static function findMatch() { 
        $method = strtolower(Request::getMethod());
        foreach (Route::$$method as $route) {
            if (preg_match($route['endpoint'], Request::getRoute(), $matches)) {
                Request::setMatchedRoute([
                    'pathParams' => self::setPathParams($matches),
                    'middlewares' => $route['middlewares'],
                    'controller' => $route['controller'],
                    'queryStrings' => Request::getQueryStrings()
                ]);
                Request::setMatchedRoutePathParam(self::setPathParams($matches));
                $executionQueue = new Queue;
                $executionQueue->next(new Request);
            }
        }
        Exception::throw("Route not fount", 404);
    }

    /**
     * This method gonna set Dinamic Path Params recived on URI
     *
     * @param array $matches
     * @return array
     */
    private static function setPathParams(array $matches) {
        
        $params = [];
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[$key] = $value;
            }
        }
        return $params;
    }

}