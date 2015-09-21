<?php

namespace Reactor\ServiceContainer;

/**
 * Interface ServiceProviderInterface
 * @package Reactor\ServiceContainer
 */
Interface ServiceProviderInterface {
    /**
     * @param ServiceContainer $container
     * @return mixed
     */
    public function getService($container = null);

    /**
     * resets internal state, usually removes shared instance
     * @return mixed
     */
    public function reset();
}
