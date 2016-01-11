<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\Common\Tools\ArrayTools;

class DynamicProcessor implements ConfigProcessorInterface {

    protected $container;

    public function __construct($configurator) {
        $this->container = $configurator->container;
    }

    public function process($config) {
        foreach ($config as $name => $value) {
            $this->container->set($name, $value);
        }
    }

}
