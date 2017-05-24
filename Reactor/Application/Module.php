<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainer;

class Module extends ServiceContainer {

    protected $dir = null;
    protected $name;

    public function __construct($name = '') {
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

    public function configure($config = array()) {
    }

    public function loadModule($name, $module_class, $config = array()) {
        $module = new $module_class($name);
        $module->setParent($this);
        $this->set($name, $module);
        $module->configure($config);
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
