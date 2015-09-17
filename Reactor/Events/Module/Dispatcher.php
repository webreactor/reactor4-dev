<?php

namespace Reactor\Events\Module;

use \Reactor\Application\Exceptions\ModuleConfiguratorExeption;

use \Reactor\Events\ContainerAwareDispatcher;

class Dispatcher extends \Reactor\Application\Module {

    protected $dispatcher;

    public function init($container = null) {
        parent::init($container);
        $this->dispatcher = new ContainerAwareDispatcher();
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
