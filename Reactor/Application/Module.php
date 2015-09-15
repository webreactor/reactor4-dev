<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;
use Reactor\ServiceContainer\ServiceContainer;

class Module extends ServiceContainer {

    protected $dir = null;
    protected $name;
    protected $path;

    public function __construct($name = '', $container = null, $data = array()) {
        $this->name = $name;
        $this->setParent($container);
        $this->data = $data;
        if ($container !== null) {
            $container->set($name, $this);    
        }
        $this->init();
    }

    public function getModulePath() {
        return $this->path;
    }

    protected function init() {
        $this->path = $this->name;
        if ($this->parent) {
            $this->path = $this->parent->getModulePath().'/'.$this->path;
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
        $module = new $module_class($name, $this, $data);
    }

    public function getDir() {
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
