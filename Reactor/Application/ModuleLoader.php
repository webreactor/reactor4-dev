<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class ModuleLoader {

    public $config_file;

    public function __construct($config_file)  {
        $this->config_file = $config_file;
    }

    public function load($parent = null) {
        $config = new ConfigurationFileLoader();
        $config->load($this->config_file);
        
        $module_class = $config['container'];
        if (!isset($config['modules'])) {
            $config['modules'] = array(); // overwrites parent
        }

        $module = new $module_class();
        $module->setParent($parent);

        $configurator = new ServiceContainerConfigurator($module);
        $configurator->load($config);

        $module->init();
        return $module;
    }

}
