<?php

namespace Reactor\ServiceContainer;

/**
 * Class EnvironmentReference
 * @package Reactor\ServiceContainer
 */
class EnvironmentReference implements ServiceProviderInterface {
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
     * @return string
     */
    public function getService($container = null) {
        return getenv($this->name);
    }

    /**
     * function for reset
     */
    public function reset() {}

}
