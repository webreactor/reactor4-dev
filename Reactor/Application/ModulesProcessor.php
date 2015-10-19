<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Configurator\Configurator;
use Reactor\ServiceContainer\Configurator\ConfigProcessorInterface;


class ModulesProcessor implements ConfigProcessorInterface {

    protected $container;

    public function __construct($configurator) {
        $this->container = $configurator->container;
    }

    public function process($config) {
        foreach ($config as $name => $module_class) {
            $this->container->loadModule($name, $module_class);
        }
    }

}
