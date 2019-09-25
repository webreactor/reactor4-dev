<?php

namespace Reactor\WebService;

class ControllerManager {

    public $container;

    function __construct($container) {
        $this->container = $container;
    }

    function handleRequest($request, $response) {
        $controller = $this->getController($request->route->node);
        $method = $this->getMethod($request);
        $body = call_user_func(array($controller, $method), $request, $response);
        if (!empty($body)) {
            $response->body = $body;
        }
    }

    function getMethod($node) {
        if (isset($node['controller_method'])) {
            return $node['controller_method'];
        }
        return 'index';
    }

    function getController($node) {
        $controller = $node['controller'];
        if (is_object($controller)) {
            return $controller;
        }
        if (isset($container[$controller])) {
            return $container[$controller];
        }
        if (class_exists($controller)) {
            return new $controller($container);
        }
        return $controller;
    }

}
