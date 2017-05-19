<?php

namespace Reactor\ServiceContainer;

class CachedServiceProvider implements ServiceProviderInterface {
    
    protected $value;
    protected $service;
    protected $cached = false;

    public function __construct(ServiceProviderInterface $service) {
        $this->service = $service;
    }

    public function getService($container) {
        if (!$this->cached) {
            $this->value = $this->service->getService($container);
            $this->cached = true;
        }
        return $this->value;
    }

    public function resetCache() {
        $this->cached = fales;
        $this->value = null;
    }

}
