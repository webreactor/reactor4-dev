<?php

namespace Reactor\AccessControl;

use Reactor\ServiceContainer\Reference;
use Reactor\ServiceContainer\ServiceProviderInterface;

class Zone implements ServiceProviderInterface {

    protected $service;
    protected $access_control;
    protected $is_init = false;

    public function __construct($name, $service, $access_control = 'access_control') {
        $this->name = $name;
        $this->service = $service;
        $this->access_control = $access_control;
    }

    public function zoneExecute($method_name, $arguments = array()) {
        if ($this->access_control && !$this->access_control->hasAccess($this->name, $method_name, $arguments)) {
            return null;
            throw new Exception("Dont have access to {$this->name}->{$method_name}", 1);
        }
        return call_user_method_array($method_name, $this->service, $arguments);
    }

    public function __call($name, $arguments) {
        return $this->zoneExecute($name, $arguments);
    }

    public function getService($container) {
        if (!$this->is_init) {
            $this->is_init = true;
            if (is_string($this->service)) {
                $this->service = $container->get($this->service);
            }
            if (is_string($this->access_control)) {
                $this->access_control = $container->get($this->access_control, null);
            }
        }
        return $this;
    }

}
