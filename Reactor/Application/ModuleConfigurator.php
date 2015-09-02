<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class ModuleConfigurator {

    protected $module;
    protected $container_configurator;

    public function __construct($module) {
        $this->module = $module;
        $this->container_configurator = new ServiceContainerConfigurator($module);
    }

    public function load($config) {
        if (!isset($config['modules'])) {
            $config['modules'] = array();
        }
        $this->container_configurator->load($config);
        foreach ($config['modules'] as $name => $module_class) {
            $this->module->loadModule($name, $module_class);
        }
    }

}
