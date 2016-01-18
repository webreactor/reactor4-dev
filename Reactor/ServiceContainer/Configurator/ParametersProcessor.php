<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\Common\Tools\ArrayTools;

class ParametersProcessor implements ConfigProcessorInterface {

    protected $container;
    protected $configurator;
    
    public function __construct($configurator) {
        $this->container = $configurator->container;
        $this->configurator = $configurator;
    }

    public function process($config) {
        $config = $this->configurator->handleValues($config);
        foreach ($config as $name => $value) {
            $this->container->set($name, $value);
        }
        foreach ($config as $name => $value) {
            $this->container->set($name, $this->container->get($name));
        }
    }

}
