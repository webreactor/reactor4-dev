<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class Module extends ServiceContainer {
    public $loaded_modules = array();

    public function __construct($container) {
        $this->setParent($container);
    }

    public function loadModule($name, $module_loader_class) {
        if (isset($this->loaded_modules[$name])) {
            return;
        }
        $this->loaded_modules[$name] = true;
        $module = new $module_class();
        $this->set($name, $module_loader->load($this));
    }

}
