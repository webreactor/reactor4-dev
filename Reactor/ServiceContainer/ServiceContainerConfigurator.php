<?php

namespace Reactor\ServiceContainer;

/**
 * configurator for service containers
 * @package Reactor\ServiceContainer
 */
class ServiceContainerConfigurator {
    /**
     * @var ValueContainer
     */
    protected $container;

    /**
     * @param ValueContainer $container
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * @param array $config
     * @throws Exceptions\ServiceConfiguratorExeption
     * @throws Exceptions\ServiceNotFoundExeption
     */
    public function load($config) {
        $config = $this->createReferences($config);

        if (isset($config['parameters'])) {
            foreach($config['parameters'] as $name => $value) {
                if ($this->container->has($name)) {
                    $data = $this->container->get($name);
                    if (is_array($data) && is_array($value)) {
                        $value = array_merge_recursive($value, $data);    
                    }
                }
                $this->container->set($name, $value);
            }
        }
        if (isset($config['services'])) {
            foreach($config['services'] as $name => $service_config) {
                $this->container->set($name, $this->createProvider($service_config));
            }
        }
    }

    /**
     * @param array $config
     * @return ServiceProvider
     * @throws Exceptions\ServiceConfiguratorExeption
     */
    public function createProvider($config) {

        $provider = new ServiceProvider();

        if (isset($config['scenario'])) {
            $this->loadScenario($provider, $config['scenario']);
        } else {
            if (!isset($config['create'])) {
                throw new Exceptions\ServiceConfiguratorExeption('Nothing to create '.var_export($config, true));
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

    /**
     * load a scenario for given provider by scenario keys
     * @param ServiceProvider $provider
     * @param array $scenario
     * @throws Exceptions\ServiceConfiguratorExeption
     */
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
                throw new Exceptions\ServiceConfiguratorExeption('Cannot parse step '.var_export($step, true));
            }
        }
    }

    /**
     * create references by specified config
     * @param array $config
     * @return array
     */
    protected function createReferences($config) {
        $data = array();
        foreach($config as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->createReferences($value);
            } else {
                if (is_string($value)) {
                    $data[$key] = $this->handleValue($value);
                } else {
                    $data[$key] = $value;
                }
            }
        }
        return $data;
    }

    /**
     * handle a value and get reference or direct service for it through special template
     * %service_name% - reference to given service
     * $name$ - refernce to environment variable by given name
     * !name! - reference to constant by given name
     * if first character after begining doubled special symbols is '*' than return value by reference
     * for example !*name! means a value of constant by name
     * @param string $value
     * @return mixed|ConstantReference|EnvironmentReference|Reference|ServiceContainer|string
     * @throws Exceptions\CircularReferenceExeption
     */
    protected function handleValue($value) {
        if (strlen($value) > 0) {
            $start = $value[0];
            $stop = substr($value, -1, 1);
            $inner_value = substr($value, 1, -1);
            if ($start == '%' && $start == $stop) {
                if (strlen($inner_value) > 0 && $inner_value[0] == '*') {
                    $inner_value = substr($inner_value, 1);
                    return (new Reference($inner_value))->getService($this->container);    
                }
                return new Reference($inner_value);
            }
            if ($start == '$' && $start == $stop) {
                if ($inner_value[0] == '*') {
                    $inner_value = substr($inner_value, 1);
                    return (new EnvironmentReference($inner_value))->getService();    
                }
                return new EnvironmentReference($inner_value);
            }
            if ($start == '!' && $start == $stop) {
                if ($inner_value[0] == '*') {
                    $inner_value = substr($inner_value, 1);
                    return (new ConstantReference($inner_value))->getService();    
                }
                return new ConstantReference($inner_value);
            }
        }

        return $value;
    }

}
