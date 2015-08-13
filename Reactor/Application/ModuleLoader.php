<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class ModuleLoader {

    protected $path;

    public function __construct() {
        $ref = new ReflectionClass($this);
        $this->path = dirname($ref->getFileName()).'/';
    }

    public function load() {
        $config = $this->config();

        $module = $this->module($config);
        $module->set('path', $this->path);

        $configurator = new ServiceContainerConfigurator($module);
        $configurator->load($this->config());

        $this->init($module);

        return $module;
    }

    protected function config() {
        $config = new ConfigurationJSONLoader();
        return $config->load($this->path.'config.json');
    }

    protected function module($config) {
        $module_class = $config['container'];
        if (!isset($config['modules'])) {
            $config['modules'] = array(); // overwrites parent
        }

        $module = new $module_class($this->parent);

        return $module;
    }

    protected function init($module) {}

}
