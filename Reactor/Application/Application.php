<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function loadConfig($config = array()) {
        $this->data = array();
        $this->is_init = true;
        $this->set($this->name, new Reference());
        $this->addAll($config);
        $this->onLoad();
        $this->init();
    }

}
