<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\Common\Tools\ArrayTools;
use Reactor\ServiceContainer\ServiceProvider;
use Reactor\ServiceContainer\Exceptions;

class ServicesProcessor implements ConfigProcessorInterface {

    protected $container;
    protected $configurator;

    public function __construct($configurator) {
        $this->container = $configurator->container;
        $this->configurator = $configurator;
    }

    public function process($config) {
        $config = $this->configurator->handleValues($config);
        foreach ($config as $name => $service_config) {
            $this->container->set($name, $this->createProvider($service_config));
        }
    }

    public function createProvider($config) {
        $provider = new ServiceProvider();
        if (isset($config['scenario'])) {
            $this->loadScenario($provider, $config['scenario']);
        } else {
            if (!isset($config['create'])) {
                throw new Exceptions\ServiceConfiguratorException('Nothing to create '.var_export($config, true));
            }
            if (!isset($config['arguments'])) {
                $config['arguments'] = array();
            }
            $provider->createScenario($config['create'], $config['arguments']);
        }

        if (isset($config['shared'])) {
            $provider->shared($config['shared']);
        }

        return $provider;
    }

    protected function loadScenario($provider, $scenario) {
        foreach ($scenario as $step) {
            if (!isset($step['arguments'])) {
                $step['arguments'] = array();
            }
            if (isset($step['create'])) {
                $provider->createScenario($step['create'], $step['arguments']);
            } elseif (isset($step['factory'])) {
                $provider->addFactory($step['factory'], $step['arguments']);
            } elseif (isset($step['call'])) {
                $provider->addCall($step['call'], $step['arguments']);
            } elseif (isset($step['configurator'])) {
                $provider->addConfigurator($step['configurator'], $step['arguments']);
            } else {
                throw new Exceptions\ServiceConfiguratorException('Cannot parse step '.var_export($step, true));
            }
        }
    }

}

