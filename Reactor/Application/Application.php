<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function loadConfig() {
        $this->onLoadDefaults();
        $this->onLoad();
        $this->onUse();
    }

}
