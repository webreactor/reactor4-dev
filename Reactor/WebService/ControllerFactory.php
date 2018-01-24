<?php

namespace Reactor\WebService;

class ControllerFactory {

    public $container;

    function __construct($container) {
        $this->container = $container;
    }

    function getController($request) {
        if (is_object($name)) {
            return $name;
        }
        if (isset($container[$name])) {
            return $container[$name];
        }
        if (class_exists($name)) {
            return new $name($container);
        }
        return $name;
    }

}
