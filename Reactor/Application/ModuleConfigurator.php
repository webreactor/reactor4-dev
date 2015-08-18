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

    public function loadJSON($file) {
        $config_loader = new ConfigurationJSONLoader();
        $full_file = $module->path.$file;
        if (!is_file($full_file)) {
            return false;
        }
        $config = $config_loader->load($full_file);
        if (!isset($config['modules'])) {
            $config['modules'] = array();
        }
        $this->container_configurator->load($config);
        return true;
    }

}
