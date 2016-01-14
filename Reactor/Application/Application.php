<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function __construct($name = 'application', $data = array()) {
        parent::__construct($name, $data);
    }

    public function configure($container = null, $config = array()) {
        $this->createService($this->name, new Reference());
        return parent::configure($container, $config);
    }

}
