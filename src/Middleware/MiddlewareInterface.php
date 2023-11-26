<?php

namespace Http\Middleware;

interface MiddlewareInterface {
    public function handler($reques, $callback);
}