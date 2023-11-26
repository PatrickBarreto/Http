<?php

namespace Http\Middleware;

class Middleware {

    protected static array $middlewares;
    
    protected static array $defaultMiddlewares;

    /**
     * This method gonna add a new middleware route for the middleware route map. If default equal true, this middleware will be executed by default for all routes.
     *
     * @param string $name
     * @param string $namespace
     * @param boolean $default
     * @return void
     */
    public static function add(string $name, string $namespace, bool $default = false) {
        self::$middlewares[$name] = $namespace;
        if($default === true) {
            self::$defaultMiddlewares[] = $name;
        }
    }

    /**
     * This methods gonna return middleware's namespace map
     */
    public static function getMiddlewaresMap() {
        return isset(static::$middlewares) ? static::$middlewares : [];
    }


    /**
     * This methods gonna return a list of middlewares name that need execute for all routes
     */
    public static function getDefaultMiddlewares() {
        return isset(static::$defaultMiddlewares) ? static::$defaultMiddlewares : [];
    }
}