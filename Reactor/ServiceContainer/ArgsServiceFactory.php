<?php

namespace Reactor\ServiceContainer;

/**
 * Class ArgsServiceFactory
 * a factory for given service name
 * @package Reactor\ServiceContainer
 */
class ArgsServiceFactory {
    /**
     * @var ServiceContainer
     */
    protected $container;
    /**
     * @var string
     */
    protected $service_name;

    /**
     * @param ServiceContainer $container
     * @param string $service_name
     */
    public function __construct($container, $service_name) {
        $this->container = $container;
        $this->service_name = $service_name;
    }

    /**
     * @param mixed $args
     * @return mixed
     * @throws Exceptions\ServiceNotFoundExeption
     */
    public function get($args) {
        return $this->getContainer($args)->get($this->service_name);
    }

    /**
     * @param mixed $args
     * @return ServiceContainer
     */
    private function getContainer($args) {
        $container = new ServiceContainer();
        $container->setParent($this->container);
        $container->setAll($args);
        return $container;
    }

}
