<?php

namespace Http\Router\Queue;

use Closure;
use Exception\Exception;
use Http\Middleware\Middleware;
use Http\Middleware\MiddlewareInterface;
use Http\Request\Request;

class Queue {

    private array $namespaceMapping = [];
    
    private array $executionQueue;

    private Closure $controller;

    private array $controllersArgs;

    /**
     * This method is responsable for instance the queue
     *
     * @param Request $request
     */
    public function __construct(){
        $this->namespaceMapping = Middleware::getMiddlewaresMap();
        $this->executionQueue   = array_unique(array_merge(Middleware::getDefaultMiddlewares(), Request::getMatchedRoute()['middlewares']));
        $this->controller       = Request::getMatchedRoute()['controller'];
    }

    /**
     * This method is responsable to execute the next middleware 
     *
     * @param Request $request
     * @return void
     */
    public function next(Request $request) {
        if($this->executionQueue ?? null) {
            $this->queueExec($request);
        }
        $this->RouteControllerExec($request);
    }

    private function RouteControllerExec(Request $request) {
        call_user_func_array($this->controller, [$request]);
    }

    /**
     * This method gonna do the queue execution
     *
     * @param Request $request
     * @return $this
     */
    private function queueExec($request){
        $middleware = $this->getNextMiddleware();
        $callback = $this->prepareCallBackForThisQueueExecution();

        return $middleware->handler($request, $callback);
    }


    /**
     * This method gonna remove the first middleware list name and return the correspondent middleware instance if it exists
     * 
     * @return MiddlewareInterface
     */
    private function getNextMiddleware() {
        $middlewareName = (array_shift($this->executionQueue));

        if(isset($this->namespaceMapping[$middlewareName])){
            $middleware = new $this->namespaceMapping[$middlewareName];
            if($middleware instanceof MiddlewareInterface){
                return $middleware;
            }
        }

        Exception::throw("Ops, we have problems to execute middlewares", 500);

    }
    

    /**
     * This method gonna prepare the callback that need to be called in next middleware.
     *
     * @return Closure
     */
    private function prepareCallBackForThisQueueExecution() {
        $thisQueue = $this;
    
        $callback = function($request) use ($thisQueue) {
            return $thisQueue->next($request);
        };

        return $callback;
    }
}
