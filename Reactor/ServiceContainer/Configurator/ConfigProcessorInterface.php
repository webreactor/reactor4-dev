<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\Common\Tools\ArrayTools;

interface ConfigProcessorInterface {

    public function __construct($configurator);
    public function process($config);

}