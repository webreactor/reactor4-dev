<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function __construct($name = '', $data = array()) {
        $this->name = $name;
        $this->data = $data;
        $this->init(null);
    }

    public function init($container) {
        if (empty($this->name)) {
            $this->name = 'application';
        }
        $this->createService($this->name, new Reference());
        $configurator = parent::init($container);
    }

}
