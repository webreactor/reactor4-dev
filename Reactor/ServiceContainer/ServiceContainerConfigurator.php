<?php

namespace Reactor\ServiceContainer;

use Reactor\Common\Tools\ArrayTools;

class ServiceContainerConfigurator {

    public $value_processors = array();
    public $processors = array();
    public $container;
    public $resource_loader;
    public $expression_processor;
    public $config = array();

    public function __construct($container) {
        $this->container = $container;
        $this->init();
    }

    // merges only first two levels or config array
    public function addConfig($config) {
        $this->config = ArrayTools::mergeRecursive($this->config, $config);
    }

    public function loadConfig($config) {
        foreach ($this->processors as $key => $processor) {
            if (!isset($config[$key])) {
                $config[$key] = array();
            }
            $processor->process($this->handleValues($config[$key]));
        }
    }

    public function load() {
        $this->loadConfig($this->config);
    }

    public function addPath($path) {
        $this->addConfig($this->resource_loader->load($path));
    }

    public function handleValues($config) {
        foreach ($this->value_processors as $processor) {
            $config = $processor->process($config);
        }
        return $config;
    }

    public function setProcessor($name, $processor) {
        $this->processors[$name] = $processor;
    }

    public function setValueProcessor($name, $processor) {
        $this->value_processors[$name] = $processor;
    }

    public function init() {
        $this->resource_loader = new Configurator\ResourceLoader\ResourceLoaderManager();

        $this->resource_loader
            ->setLoader('.json', new Configurator\ResourceLoader\ResourceLoaderJSON())
            ->setLoader('.yml', new Configurator\ResourceLoader\ResourceLoaderYAML());

        $this->resource_loader
            ->setProcessor('inline_import', new Configurator\ResourceLoader\InlineImportProcessor($this->resource_loader));

        $this->resource_loader
            ->setProcessor('import', new Configurator\ResourceLoader\ImportProcessor($this->resource_loader));


        $this->setValueProcessor('expressions', new Configurator\ExpressionProcessor($this));

        $this->setProcessor('dynamic', new Configurator\DynamicProcessor($this));
        $this->setProcessor('parameters', new Configurator\ParametersProcessor($this));
        $this->setProcessor('services', new Configurator\ServicesProcessor($this));
    }

}
