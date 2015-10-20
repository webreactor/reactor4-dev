<?php

namespace Reactor\Events\Module;

use \Reactor\Application\Exceptions\ModuleConfiguratorException;

use \Reactor\Events\ContainerAwareDispatcher;

class Dispatcher extends \Reactor\Application\Module {

    protected $dispatcher;

    public function init($container, $config = array()) {
        $configurator = parent::init($container, $config);
        $this->dispatcher = new ContainerAwareDispatcher();
        return $configurator;
    }

    public function getService($container = null) {
        parent::getService($container);
        $this->dispatcher->setContainer($this->get('application'));
        return $this->dispatcher;
    }

    public function __sleep() {
        parent::__sleep();
        $this->dispatcher->setContainer(null);
    }

}
