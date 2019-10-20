<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function __construct() {
        $this->onLoad();
        $this->onUse();
    }

}
