<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;
use Reactor\ServiceContainer\ServiceContainer;

class Module extends ServiceContainer {

    protected $dir = null;
    protected $name;
    protected $path;

    public function __construct($name = '', $data = array()) {
        $this->path = $this->name = $name;
        $this->data = $data;
    }

    public function getModulePath() {
        return $this->path;
    }

    public function init($container) {
        if ($container !== null) {
            $this->setParent($container);
            $this->path = $this->parent->getModulePath().'/'.$this->name;
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

    /**
     * @param string $name
     * @param string $module_class
     * @return Module
     * @throws \Reactor\ServiceContainer\Exceptions\ServiceNotFoundExeption
     */
    public function loadModule($name, $module_class) {
        $data = array();
        if ($this->has($name)) {
            $existing_data = $this->get($name);
            if (is_array($existing_data)) {
                $data = $existing_data;
            }
        }
        /** @var Module $module */
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

    public function getName() {
        return $this->name;
    }
}
