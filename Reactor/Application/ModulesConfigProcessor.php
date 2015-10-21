<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Configurator\Configurator;
use Reactor\ServiceContainer\Configurator\ConfigProcessorInterface;


class ModulesConfigProcessor implements ConfigProcessorInterface {

    protected $container;

    public function __construct($configurator) {
        $this->container = $configurator->container;
    }

    public function process($config) {
        foreach ($config as $name => $module) {
            if (is_string($module)) {
                $this->container->loadModule($name, $module);
            } else {
                if (!isset($module['config'])) {
                    $module['config'] = array();
                }
                $this->container->loadModule($name, $module['class'], $module['config']);
            }
        }
    }

}
