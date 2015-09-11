<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    protected function init() {
        if (empty($this->name)) {
            $this->name = 'application';
        }
        $this->createService($this->name, new Reference());
        $configurator = parent::init();
    }

}
