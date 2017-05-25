<?php

namespace Reactor\Application;

class Application extends Module {

    public function __construct($name) {
        parent::__construct('application');
    }

    public function loadConfig($config = array()) {
        $this->data = array();
        $this->is_init = true;
        $this->set('application', new Reference());
        $this->addAll($config);
        $this->onLoad();
        $this->init();
    }

}
