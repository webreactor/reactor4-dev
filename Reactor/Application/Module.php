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

    public function init($container) {
        if ($container !== null) {
            $this->setParent($container);
            $this->full_name = $this->parent->getFullName().'/'.$this->name;
        }
        $configurator = new ModuleConfigurator($this);
        $config_file = $this->getDir().'config.json';
        if (is_file($config_file)) {
            $config_loader = new ConfigurationReaderJSON();
            $config = $config_loader->load($config_file);
            $configurator->load($config);
        }
        return $configurator;
    }

    public function loadModule($name, $module_class) {
        $data = array();
        if ($this->has($name)) {
            $existing_data = $this->get($name);
            if (is_array($existing_data)) {
                $data = $existing_data;
            }
        }
        $module = new $module_class($name, $data);
        $this->set($name, $module);
        $module->init($this);
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
