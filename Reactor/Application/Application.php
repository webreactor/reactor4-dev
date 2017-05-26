<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function loadConfig($config = array()) {
        $this->data = array();
        $this->is_init = true;
        $this->addAll($config);
        $this->onLoad();
        $this->init();
    }

}
