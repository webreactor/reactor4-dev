<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function __construct($name = 'application', $data = array()) {
        parent::__construct($name, $data);
        $this->init(null);
    }

    public function init($container) {
        $this->createService($this->name, new Reference());
        $configurator = parent::init($container);
    }

}
