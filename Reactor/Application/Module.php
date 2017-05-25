<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainer;
use Reactor\ServiceContainer\ServiceProviderInterface;
use Reactor\Common\Tools\ArrayTools;

class Module extends ServiceContainer implements ServiceProviderInterface {

    protected $dir = null;
    protected $name;
    protected $is_init = false;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getFullName() {
        if ($this->parent) {
            return $this->parent->getFullName().'/'.$this->name;
        }
        return '/'.$this->name;
    }

    public function getName() {
        return $this->name;
    }

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

    public function addAll($values) {
        foreach ($values as $key => $value) {
            $module->set($key, $value);
        }
    }

    public function loadModule($name, $module_class, $config = array()) {
        $module = new $module_class($name);
        $this->set($name, $module);
        $module->setParent($container);
        $module->addAll($this->get($name, array()));
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
