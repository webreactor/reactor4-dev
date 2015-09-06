<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function init() {
        $configurator = parent::init();
        $this->createService('application', new Reference());
    }

}
