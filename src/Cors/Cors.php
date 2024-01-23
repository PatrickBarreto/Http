<?php

namespace Http\Cors;

use Exception\Exception;

class Cors {

    private static array $allowedOrigins;

    /**
     * This method is responsable to enable CORS headers.
     */
    public static function enableCORS(  array $accessControlAllowOrigin = ['*'], 
                                        array $accessControlAllowMethods = ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                                        array $accessControlAllowHeaders = ['Content-Type'],
                                        bool $accessControlAllowCredentials = false,
                                        array $accessControlExposeHeaders = ['Content-Type'],
                                        int $accessControlMaxAge = 86400 
                                    ){

        self::$allowedOrigins = $accessControlAllowOrigin;
        header("Access-Control-Allow-Origin: ".self::checkIfOriginIsAllowed());
        header("Access-Control-Allow-Methods: ".implode(",",$accessControlAllowMethods));
        header("Access-Control-Max-Age: ".$accessControlMaxAge);
        header("Access-Control-Allow-Headers: ".implode(",",$accessControlAllowHeaders));
        header("Access-Control-Expose-Headers: ".implode(",",$accessControlExposeHeaders));
        header(($accessControlAllowCredentials == true) ? 'Access-Control-Allow-Credentials: true' : 'Access-Control-Allow-Credentials: false');
        
        self::preventPreflightRequest();

    }


    /**
     * This method is responsable to check if the request origin is allowed 
     */
    private static function checkIfOriginIsAllowed() {
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : 'http://localhost';
        if(self::$allowedOrigins[0] != "*"){
            if (in_array($origin, self::$allowedOrigins)){
                return $origin;
            }
            Exception::throw('Access denied', 403);
        }
        return "*";
    }

    /**
     * This method will prevet flight level request
     */
    private static function preventPreflightRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            header("HTTP/1.1 200 OK");
            exit;
        }
    }






}