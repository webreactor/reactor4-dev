<?php

namespace Reactor\WebApp;

class ControllerFactory {

    public $container;

    function __construct($container) {
        $this->container = $container;
    }

    function getController($name) {
        if (is_object($name)) {
            return $name;
        }
        if (isset($container[$name])) {
            return $container[$name];
        }
        if (class_exists($name)) {
            return new $name($container);
        }
        if (is_callable($name)) {
            return $name;
        }
        return $name;
    }

}
