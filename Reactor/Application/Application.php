<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function __construct($name = '', $data = array()) {
        $this->name = $name;
        $this->data = $data;
        $this->init();
    }

    public function init($container = null) {
        if (empty($this->name)) {
            $this->name = 'application';
        }
        $this->createService($this->name, new Reference());
        $configurator = parent::init();
    }

}
