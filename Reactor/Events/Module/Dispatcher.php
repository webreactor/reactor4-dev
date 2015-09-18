<?php

namespace Reactor\Events\Module;

use \Reactor\Application\Exceptions\ModuleConfiguratorException;

use \Reactor\Events\ContainerAwareDispatcher;

class Dispatcher extends \Reactor\Application\Module {

    protected $dispatcher;

    public function init() {
        $configurator = parent::init();
        $this->dispatcher = new ContainerAwareDispatcher();
        return $configurator;
    }

    public function getService($container = null) {
        parent::getService($container);
        $this->dispatcher->setContainer($this->get('application'));
        return $this->dispatcher;
    }

    public function reset() {
        parent::reset();
        $this->dispatcher->setContainer(null);
    }

}
