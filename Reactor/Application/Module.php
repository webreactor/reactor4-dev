<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainer;
use Reactor\Common\Tools\ArrayTools;

class Module extends ServiceContainer {

    protected $dir = null;
    protected $name;

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

    public function configure() {
    }

    public function addRawData($values) {
        $this->data = array_merge($this->data, $values);
    }

    public function loadModule($name, $module_class, $config = array()) {
        $module = new $module_class($name);
        $module->addRawData($this->get($name, array()));
        $module->addRawData($config);
        $module->setParent($this);
        $this->set($name, $module);
        $module->configure();
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
