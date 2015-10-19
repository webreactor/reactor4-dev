<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\Common\Tools\ArrayTools;

class ImportProcessor implements ConfigProcessorInterface {

    protected $configurator;

    public function __construct($configurator) {
        $this->configurator = $configurator;
    }

    public function process($config) {
        $context = dirname($this->configurator->config_context) . '/';
        foreach ($config as $path) {
            $this->configurator->loadPath(realpath($context.$path));
        }
    }

}
