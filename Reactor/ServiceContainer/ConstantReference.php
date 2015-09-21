<?php

namespace Reactor\ServiceContainer;

/**
 * Class ConstantReference
 * @package Reactor\ServiceContainer
 */
class ConstantReference implements ServiceProviderInterface {
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * @param ServiceContainer $container
     * @return mixed
     */
    public function getService($container = null) {
        return constant($this->name);
    }

    /**
     * function for reset
     */
    public function reset() {}

}
