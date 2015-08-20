<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class Module extends ServiceContainer {

    public $path = null;

    public function __construct($container) {
        $this->setParent($container);

        $ref = new ReflectionClass($this);
        $this->path = dirname($ref->getFileName()).'/';

        $this->init();
    }

    public function init() {
        $configurator = new ModuleConfigurator($this);
        $configurator->loadJSON('config.json');
        $module->loadModules();
        return $configurator;
    }

    public function loadModules() {
        foreach ($this->data as $key => $value) {
            if (is_a($value, 'Reactor\\Application\\Module')) {
                $this->get($key);
            }
        }
    }

}
