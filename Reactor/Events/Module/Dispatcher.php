<?php

namespace Reactor\Events\Module;

use \Reactor\Application\Exceptions\ModuleConfiguratorExeption;

use \Reactor\Events\ContainerAwareDispatcher;

class Dispatcher extends \Reactor\Application\Module {
    /**
     * @var ContainerAwareDispatcher
     */
    protected $dispatcher;

    public function init() {
        parent::init();
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
