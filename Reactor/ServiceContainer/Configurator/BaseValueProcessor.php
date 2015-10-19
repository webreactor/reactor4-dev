<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\ServiceContainer\Configurator\ConfigProcessorInterface;
use Reactor\Common\Tools\ArrayTools;

class BaseValueProcessor implements ConfigProcessorInterface {

    protected $configurator;
    protected $key;

    public function __construct($configurator) {
        $this->configurator = $configurator;
        $this->init();
    }

    public function process($config) {
        $callback = array($this, 'handleValue');
        return ArrayTools::walkRecursive($config, $callback);
    }

    public function init() {

    }

    public function handleValue($value) {
        return $value;
    }

}
