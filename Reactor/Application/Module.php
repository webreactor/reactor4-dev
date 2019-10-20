<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainer;
use Reactor\ServiceContainer\ServiceProviderInterface;
use Reactor\ServiceContainer\Reference;

use Reactor\AccessControl\Zone;

class Module extends ServiceContainer implements ServiceProviderInterface {

    protected $dir = null;
    protected $is_used = false;

    protected function onLoad() {
    }

    protected function onUse() {
    }

    public function set($name, $value) {
        if ($value instanceof Module) {
            $parent_config = $this->get($name, null);
            parent::set($name, $value);
            if (is_array($parent_config)) {
                $value->setAll($parent_config);
            }
            $value->onLoad();
        } else {
            parent::set($name, $value);
        }
    }

    public function callService($path, $method = null, $args = array()) {
        $service = $this->getByPath($path);
        if ($method === null) {
            return $service;
        }
        return call_user_func_array(array($service, $method), $args);
    }

    public function provideService($container) {
        if (!$this->is_used) {
            $this->is_used = true;
            $this->onUse();
        }
        return $this;
    }

    public function setSecure($name, $value, $access_control = 'access_control') {
        $this->set($name, new Zone($name, $value, $access_control));
    }

    public function resolveService($path_or_service, $default = '_throw_exception_') {
        if (is_string($path_or_service)) {
            return $this->getByPath($path_or_service, $default);
        }
        if ($path_or_service instanceof ServiceProviderInterface) {
            return $path_or_service->provideService($this);
        }
        return $path_or_service;
    }

    public function getDir() {
        if ($this->dir === null) {
            $ref = new \ReflectionClass($this);
            $this->dir = dirname($ref->getFileName()).'/';
        }
        return $this->dir;
    }

}
