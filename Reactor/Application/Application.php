<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainer;

class Application extends ServiceContainer {

    public $loaded_modules = array();

    public function loadModules() {
        do {
            $to_load = array_diff($this->application->get('modules'), array_keys($this->loaded_modules));
            foreach ($to_load as $module_class) {
                $this->loadModule($module_class);
            }
        } while(count($to_load) > 0);
    }

    public function loadModule($module_class) {
        if (isset($this->loaded_modules[$module_class])) {
            return;
        }
        $this->loaded_modules[$module_class] = true;
        $module = new $module_class();
        $module->init($this);
    }

}
