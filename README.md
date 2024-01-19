# About Package
This package gonna make all the essential HTTP ressources for your API projetc.

# How to install
```sh 
composer require patrick-barreto/Http
```

# How to Use

**Important:** Make sure that in your server configuration file you are redirecting all requests to index.php.

Basically you will use the  Http abstration to manipulate all ressources from this package.
```php
use Http\Http;
```

# Roates
* POST
    ```php
    Http::post(string $endpoint, Closure $controllerCallBack, array $middlewares = []);
    ```
* GET   
    ```php
    Http::get(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```
* PUT   
    ```php
    Http::put(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```
* PATCH   
    ```php
    Http::patch(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```
* DELETE   
    ```php
    Http::delete(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```



**Important:** For the same http method declaration, the routes order must be:
- statics routes first, 
- and dinamic routes last

---
# Middlewares
## Create a middleware
You need to import Middleware Interface to certificate that you were implemented a valid Middleware sintaxe for system. 

Your middleware must be a class like this:
```php
<?php

use Http\Middleware\MiddlewareInterface;

class Middleware implements MiddlewareInterface {
    public function handler($request, $callback){
        //Put your code here, change the $request instance..
        return $callback($request);
    }
}
```
***Important***: This is the instance of request that you can manipulate and insert information from your system. This instance is accessible for you in the callback function parameter that you need to pass in the routes. 


## Use yours middlewares
To use your middlewares you need to fill the system with theirs namespaces and inform if the execution is default or not. 

Add new middleware namespace to middlewares namespaces map
```php
Http::middleware(string $name, string $namespace, bool $defaultForAllRoutes = false)
```

Default middlewares are executed for all routes. 

***important:*** Like the routes, the order of default middlewares declaration are very important. It will be the execution order. For middlewares not default, to use them you need to inform the name of middleware, in execution order to be executed after default middlewares.

---


# Response
To send a response for anyone request you cant use Http::response, the method have default values for default responses. 

```php
Http::response($response = ['success'=>true],  int $statusCode = 200, array $headers = ["Content-Type" => "application/json"]) ;
```
---

# Request Class
The Request Class store usefull data from the request. This informations are static and acessible in anywhere in your sistem.

During the middlewares you can increment your personal data into request intance class that will be give to you in callback param on routes declaration, where you will pass to your controller all request or specfic data.

Your specific data will not be a static data, will be a instance data. The static data will be access by these bellow methods

You can find here:
1. HTTP Method
2. HTTP Headers
3. Request Route
4. Query Strings
5. Path Params
6. Request Body

The first param in callback is reserved to request, you are free to name it as you want.

## Methods

This method is responsable to return the request method
```php
public static function getMethod()
```
- return string

This method is responsable to return the request Headers
```php
public static function getHeaders()
```
- return array

This method is responsable to return the request param data, path params and query strings
```php   
public static function getRoute()
```
- return array|string

This method is responsable to set the query string data.
```php            
public static function getQueryStrings()
```
- return array

This method is responsable to get the path params
```php    
public static function getPathParams()
```

- return array

This method is responsable to return the request all data method

```php   
public static function getAllStaticData()
```
- return array

This method is responsable to return the request Body
```php            
public static function getBody()
```
- return array
---

# Run
- After routes and middlewares declaration and midlleware names mapped, start the aplication.
    ```php
    Http::run()
    ```
---



# **EXEMPLES**:
Exemple to use this package

# Middleware Delcaration
```php
<?php
namespace Api\Middlewares;

use Http\Middleware\MiddlewareInterface;

class Authorization implements MiddlewareInterface {
    public function handler($request, $callback){
        $request->auth = $this->validadeToken($request);
        return $callback($request);
    }

    private function validadeToken($request){
        //Validade with request headers and return true or false
    }
}
```
```php
<?php
namespace Api\Middlewares;

use Http\Middleware\MiddlewareInterface;

class AccessTokenValidade implements MiddlewareInterface {
    public function handler($request, $callback){
        //Validade your accessToken
        return $callback($request);
    }
}
```

---        

# MiddlewaresMap.php
This file will fill Midleware Queue with middleware namespace and names.

```php
<?php
use Http\Http;

//Middlewares default
Http::middleware('AccessTokenValidade', 'Api\Middlewares\AccessTokenValidade', true);

//Middlewares to routes use.
Http::middleware('Auth', 'Api\Middlewares\Authorization');
```

---   

# Routes.php
This will be the file when we will make routes declarate. It can be with more than one file too..
```php
<?php

use Http\Http;

Http::post('/createAccount', function($request) {
    $return = new YourController($request);
    Http::response());

Http::post('/login', function($request) {
    $return = new YourController($request);
    Http::response($return, 
                    200, 
                    [
                        ["Content-Type" => "application/json"],
                        ['Authorization' => $return['JWT']],
                    ]);
                });

Http::get('/users', function($request) {
    $return = new YourController($request);
    Http::response($return)
}, 
['Auth']);
```

---

# index.php
```php
    <?php

    use Http\Http;

    require_once "./vendor/autoload.php"; //autoload PSR-4
    require_once "./MiddlewaresMap.php";
    require_once "./Routes.php";

    //if you need to put anything more in this system part, put here.

    Http::run();
```


