<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\Reference;

class Application extends Module {

    public function __construct($name = 'application', $data = array()) {
        parent::__construct($name, $data);
        if ($name !== null) {
            $this->configure();
        }
    }

    public function configure($container = null, $config = array()) {
        $this->createService($this->name, new Reference());
        return parent::configure($container, $config);
    }

    public static function __set_state($state) {
        $obj = new static(null);
        $obj->restore_state($state);
        return $obj;
    }

}
