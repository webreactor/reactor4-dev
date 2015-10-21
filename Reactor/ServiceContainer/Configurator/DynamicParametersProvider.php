<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\ServiceContainer\ServiceProviderInterface;
use Reactor\ServiceContainer\ServiceContainer;

class DynamicParametersProvider implements ServiceProviderInterface {

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getService($container = null) {
        return $container->resolveProviders($this->data);
    }

    public static function __set_state($state) {
        return new self($state['data']);
    }

    public function __sleep() {
        ServiceContainer::sleepProviders($this->data);
    }

}
