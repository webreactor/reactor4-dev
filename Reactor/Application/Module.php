<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainer;
use Reactor\ServiceContainer\ServiceProviderInterface;
use Reactor\ServiceContainer\Reference;

use Reactor\AccessControl\Zone;

class Module extends ServiceContainer implements ServiceProviderInterface {

    protected $dir = null;
    protected $is_init = false;

    public function onLoad() {
    }

    public function init() {
    }

    public function getService($container) {
        if (!$this->is_init) {
            $this->is_init = true;
            $this->init();
        }
        return $this;
    }

    public function setService($name, $value) {
        foreach ($this->get('service_wrappers', array()) as $wrapper) {
            $value = $wrapper->wrap($this, $this->getFullName().$name, $value);
        }
        $this->set($name, $value);
    }

    public function resolveService($path_or_service, $default = '_throw_exception_') {
        if (is_string($path_or_service)) {
            return $this->getByPath($path_or_service, $default);
        }
        if ($path_or_service instanceof ServiceProviderInterface) {
            return $path_or_service->getService($container);
        }
        return $path_or_service;
    }

    public function loadModule($name, $module_class, $config = array()) {
        $module = new $module_class();
        $parent_config = $this->get($name, array());
        $this->set($name, $module);
        $module->addAll($parent_config);
        $module->addAll($config);
        $module->onLoad();
        return $module;
    }

    public function getDir() {
        if ($this->dir === null) {
            $ref = new \ReflectionClass($this);
            $this->dir = dirname($ref->getFileName()).'/';
        }
        return $this->dir;
    }

}
