<?php

namespace Reactor\AccessControl;

class Zone {

    protected $service;
    protected $object;
    protected $access_control;

    public function __construct($name, $service, $access_control) {
        $this->name = $name;
        $this->service = $service;
        $this->access_control = $access_control;
    }

    public function zoneExecute($method_name, $arguments = array()) {
        if ($this->access_control->hasAccess($this->name, $method_name, $arguments)) {
            return call_user_method_array($method_name, $this->object, $arguments);
        }
        return null;
        throw new Exception("Dont have access to {$this->name}->{$method_name}", 1);
    }

    public function __call($name, $arguments) {
        return $this->zoneExecute($name, $arguments);
    }

    public function getService($container) {
        if (!$this->object) {
            $this->object = $this->service->getService($container);    
        }
        return $this;
    }

}
