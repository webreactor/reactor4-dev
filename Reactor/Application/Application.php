<?php

namespace Reactor\Application;

class Application extends Module {

    public function __construct($name = 'application', $data = array()) {
        parent::__construct($name, $data);
    }

    public function configure($container = null, $config = array()) {
        return parent::configure($container, $config);
    }

}
