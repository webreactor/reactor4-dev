<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class Module extends ServiceContainer {
    public $loaded_modules = array();

    public function init() {
        do {
            $to_load = array_diff($this->get('modules'), array_keys($this->loaded_modules));
            foreach ($to_load as $module_class) {
                $this->loadModule($module_class);
            }
        } while(count($to_load) > 0);
    }

    public function loadModule($name, $module_loader_class) {
        if (isset($this->loaded_modules[$name])) {
            return;
        }
        $this->loaded_modules[$name] = true;
        $module_loader = new $module_loader_class();
        $this->set($name, $module_loader->load($this));
    }
}
