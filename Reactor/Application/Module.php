<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;
use Reactor\ServiceContainer\ServiceContainer;

class Module extends ServiceContainer {

    protected $dir = null;
    protected $name;
    protected $full_name;

    public function __construct($name = '', $data = array()) {
        $this->full_name = $this->name = $name;
        $this->data = $data;
    }

    public function getFullName() {
        return $this->full_name;
    }

    public function getName() {
        return $this->name;
    }

    public function configure($container, $config = array()) {
        if ($container !== null) {
            $this->setParent($container);
            $this->full_name = $this->parent->getFullName().'/'.$this->name;
        }
        $configurator = new ServiceContainerConfigurator($this);
        $configurator->setProcessor('modules', new ModulesConfigProcessor($configurator));

        $config_file = $this->getDir().'config.json';
        if (is_file($config_file)) {
            $configurator->addPath($config_file);
        }

        $configurator->addConfig($config);
        $configurator->load();
        return $configurator;
    }

    public function loadModule($name, $module_class, $config = array()) {
        $data = array();
        $module = new $module_class($name);
        $this->set($name, $module);
        $module->configure($this, $config);
        return $module;
    }

    public function getDir() {
        if ($this->dir === null) {
            $ref = new \ReflectionClass($this);
            $this->dir = dirname($ref->getFileName()).'/';
        }
        return $this->dir;
    }

    public function __sleep() {
        parent::__sleep();
        $this->dir = null;
    }

}
