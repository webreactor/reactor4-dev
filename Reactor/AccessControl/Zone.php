<?php

namespace Reactor\AccessControl;

use Reactor\ServiceContainer\Reference;
use Reactor\ServiceContainer\ServiceProviderInterface;

class Zone implements ServiceProviderInterface {

    protected $service;
    protected $access_control;
    protected $container;
    protected $is_init = false;

    public function __construct($name, $service, $access_control = 'access_control') {
        $this->name = $name;
        $this->service = $service;
        $this->access_control = $access_control;
    }

    public function zoneExecute($method_name, $arguments = array()) {
        if (!$this->access_control->hasAccess($this->name, $method_name, $arguments)) {
            return null;
            throw new Exception("No access to {$this->name}->{$method_name}", 1);
        }
        return call_user_func_array(array($this->container->resolveService($this->service), $method_name), $arguments);
    }

    public function __call($name, $arguments) {
        return $this->zoneExecute($name, $arguments);
    }

    public function provideService($container) {
        if (!$this->is_init) {
            $this->is_init = true;
            $this->container = $container;
            $this->access_control = $container->resolveService($this->access_control);
        }
        return $this;
    }

}
