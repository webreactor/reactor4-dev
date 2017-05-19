<?php

namespace Reactor\ServiceContainer;

class CachedServiceProvider implements ServiceProviderInterface {
    
    protected $value;
    protected $service;

    function __construct(ServiceProviderInterface $service) {
        $this->service = $service;
    }

    function getService($container) {
        if ($this->service) {
            $this->value = $this->service->getService($container);
            $this->service = null;
        }
        return $this->value;
    }

}
