nano# About Package

This package gonna make for your API projetc all the essential HTTP ressources, like prepare the request data with , create routes, routin the request to controller, prepare and send response, execute middlewares, catching query strings and path params.


# How to install
```sh 
composer require patrick-barreto/Http
```

# How to Use
Basically you will use and abstraction that will manipulate any class of implementation. 

This class is the Http Class.
```php
use Http\Http;
```

This class have these commands:


### Routes
* Create POST routes
    ```php
    Http::post(string $endpoint, Closure $controllerCallBack, array $middlewares = []);
    ```
* Create GET routes   
    ```php
    Http::get(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```
* Create PUT routes   
    ```php
    Http::put(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```
* Create PATCH routes   
    ```php
    Http::patch(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```
* Create DELETE routes   
    ```php
    Http::delete(string $endpoint, Closure $controllerCallBack, array $middlewares = [])
    ```
 
You can use this commands in a unique file for all routes and import in your bootstrap file.
Or you can use it managed by one class with methods for class of routes (Users, orders, ...) and instance this class in your bootstrap file.. You are free to choice the way.

**Important:**
The order of middleware name declaration is important for execution. After default middlewares execution, the routes middlewares will be executed in order of declaration.

### Midlewares
* Create map middlewares routes
    ```php
    Http::middleware(string $name, string $namespace, bool $defaultForAllRoutes = false)
    ```

This are similar to routes, you can use how you want. 

Like routes, the order of default middlewares are very important. It will be the order of execution. Put first the defaults, in order, after put the rest of middlewares namespaces.

### Response
- Make the response 
    ```php
    Http::response($response = ['success'=>true],  int $statusCode = 200, array $headers = ["Content-Type" => "application/json"]) ;
    ```

### Run app
- Start the aplication to process the http request
    ```php
    Http::run()
    ```


#### Using:
    
- routes.php
    ```php
    <?php

    use Http\Http;

    Http::post('/createAccount', function($params) {
        $return = new YourController($params);
        Http::response());

    Http::post('/login', function($params) {
        $return = new YourController($params);
        Http::response($return, 
                        200, 
                        [
                            ["Content-Type" => "application/json"],
                            ['Authorization' => $retur['JWT']],
                        ]);
                    });
    
    Http::get('/users', function($params) {
        $return = new YourController($params);
        Http::response($return)
    }, 
    ['Auth']);
    ```

- middlewares.php
