<?php

namespace Http\Request;

class Request {
    
    private static string $method;
    private static array $headers;
    private static string $route;
    private static array $queryStrings;
    private static array $body;
    private static array $matchedRoute;
    
    /**
     * This method is responsable to instance the Request and prepare the request object data
     */
    public function __construct() {
       self::setData();
       return $this;
    }


    /**
     * This method is responsable to instance the Request and prepare the request static data;
     */
    public static function setData(){
        self::$method       = $_SERVER['REQUEST_METHOD'];
        self::$headers      = getallheaders();
        self::$route        = $_REQUEST['route'];
        self::$queryStrings = array_slice($_REQUEST, 1, null, true);
        self::$body         = (self::$method == 'POST' || self::$method == 'PUT' || self::$method == 'PATCH') ? [file_get_contents("php://input")] : [];
        self::$body         = (self::$body) ? self::$body : [];
    }



    // Trait can't be used with static properties. 
    // For better mantains this, all get set methods need to be in the same order than list of
    // class properties
    
    /**
     * This method is responsable to return the request method
     *
     * @return string
     */    
    public static function getMethod() {
        return self::$method;
    }
    
    /**
     * This method is responsable to return the request Headers
     *
     * @return array
     */
    public static function getHeaders() {
        return self::$headers;
    }
    
    /**
     * This method is responsable to return the request param data, path params and query strings
     *
     * @return array|string
     */
    public static function getRoute() {
        return self::$route;
    }


    /**
     * This method is responsable to set the query string data.
     *
     * @return array
     */
    public static function getQueryStrings() {
        return self::$queryStrings;
    }


    /**
     * This method is responsable to return the request Body
     *
     * @return object
     */
    public static function getBody() {
        return json_decode(self::$body[0]);
    }

        
    /**
     * This method is responsable to set the request MatchedRoute
     * @param array $route
     * @return void
     */    
    public static function setMatchedRoute(array $routeData) {
        self::$matchedRoute = $routeData;
    }

     /**
     * This method is responsable to return the request method
     *
     * @return array
     */    
    public static function getMatchedRoute() {
        return self::$matchedRoute;
    }

}