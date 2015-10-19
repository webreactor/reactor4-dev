<?php

namespace Reactor\ServiceContainer;

class ServiceContainerConfigurator {

    public $value_processors = array();
    public $processors = array();
    public $container;
    public $resource_loader;
    public $expression_processor;

    public function __construct($container) {
        $this->container = $container;
    }

    public function load($config) {
        foreach ($this->processors as $key => $processor) {
            if (!isset($config[$key])) {
                $config[$key] = array();
            }
            $processor->process($this->handleValues($config[$key]));
        }
    }

    public function loadPath($path) {
        $this->config_context = $path;
        $config = $this->loadResource($path);
        if ($config) {
            $this->load($config);
        }
        $this->config_context = null;
    }

    public function loadResource($path) {
        return $this->resource_loader->load($path);
    }

    public function handleValues($config) {
        foreach ($this->value_processors as $processor) {
            $config = $processor->process($config);
        }
        return $config;
    }

    public function addProcessor($name, $processor) {
        $this->processors[$name] = $processor;
    }

    public function addValueProcessor($name, $processor) {
        $this->value_processors[$name] = $processor;
    }

    static function factory($container) {
        $configurator = new self($container);

        $configurator->resource_loader = new Configurator\ResourceLoader\ResourceLoaderManager();
        $configurator->resource_loader
            ->addLoader('.json', new Configurator\ResourceLoader\ResourceLoaderJSON());

        $configurator->addValueProcessor('expressions', new Configurator\ExpressionProcessor($configurator));

        $configurator->addProcessor('parameters', new Configurator\ParametersProcessor($configurator));
        $configurator->addProcessor('import', new Configurator\ImportProcessor($configurator));
        $configurator->addProcessor('services', new Configurator\ServicesProcessor($configurator));
        return $configurator;
    }

}
