<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

use Reactor\ServiceContainer\ServiceProviderInterface;

class ModuleLoader implements ServiceProviderInterface {

    protected $path;

    public function __construct() {
        $ref = new ReflectionClass($this);
        $this->path = dirname($ref->getFileName()).'/';
    }

    public function getService($container = null) {
        $config = $this->config();

        $module = $this->module($config, $container);
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

    protected function module($config, $container) {
        $module_class = $config['container'];
        if (!isset($config['modules'])) {
            $config['modules'] = array(); // overwrites parent
        }

        $module = new $module_class($container);

        return $module;
    }

    protected function init($module) {
        $to_load = $module->get('modules');
        foreach ($to_load as $module_class) {
            $module->loadModule($module_class);
        }
    }

    protected function reset() {}

}
