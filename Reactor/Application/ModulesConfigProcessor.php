<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Configurator\Configurator;
use Reactor\ServiceContainer\Configurator\ConfigProcessorInterface;


class ModulesConfigProcessor implements ConfigProcessorInterface {

    protected $container;
    protected $configurator;

    public function __construct($configurator) {
        $this->container = $configurator->container;
        $this->configurator = $configurator;
    }

    public function process($config) {
        foreach ($config as $name => $module) {
            if (is_string($module)) {
                $_module = $this->configurator->handleValues($module);
                $this->container->loadModule($name, $_module);
            } else {
                if (!isset($module['config'])) {
                    $module['config'] = array();
                }
                $_module = $this->configurator->handleValues($module['class']);
                $this->container->loadModule($name, $_module, $module['config']);
            }
        }
    }

}
