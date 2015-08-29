<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;
use Reactor\ServiceContainer\ServiceContainer;

class Module extends ServiceContainer {

    protected $dir = null;

    public function __construct($container = null, $data = array()) {
        $this->setParent($container);
        $this->data = $data;
        $this->init();
    }

    public function init() {
        $configurator = new ModuleConfigurator($this);
        $config_file = $this->dir().'config.json';
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
        $module = new $module_class($this, $data);
        $this->set($name, $module);
    }

    public function dir() {
        if ($this->dir === null) {
            $ref = new \ReflectionClass($this);
            $this->dir = dirname($ref->getFileName()).'/';
        }
        return $this->dir;
    }

    public function getName() {
        return $this->name;
    }
}
