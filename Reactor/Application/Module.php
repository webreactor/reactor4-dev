<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class Module extends ServiceContainer {

    public $loaded_modules = array();
    public $path = null;

    public function __construct($container) {
        $this->setParent($container);

        $ref = new ReflectionClass($this);
        $this->path = dirname($ref->getFileName()).'/';
        
        $this->init();
    }

    public function init() {
        $configurator = new ModuleConfigurator($this);
        $configurator->loadJSON('config.json');
        $module->loadModules($module->get('modules'));
        return $configurator;
    }

    public function loadModules($modules) {
        foreach ($modules as $name => $module_class) {
            $module->loadModule($name, $module_class);
        }
    }

    public function loadModule($name, $module_class) {
        if (isset($this->loaded_modules[$name])) {
            return;
        }
        $this->loaded_modules[$name] = true;
        $this->set($name, new $module_class($this));
    }

}
