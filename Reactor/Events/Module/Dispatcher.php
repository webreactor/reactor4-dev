<?php

namespace Reactor\Events\Module;

use \Reactor\Application\Exceptions\ModuleConfiguratorException;

use \Reactor\Events\ContainerAwareDispatcher;

/**
 * Class Dispatcher - base class for dispatchers of events
 * @package Reactor\Events\Module
 */
class Dispatcher extends \Reactor\Application\Module {
    /**
     * @var ContainerAwareDispatcher
     */
    protected $dispatcher;

    /**
     * @param \Reactor\Application\Module $container
     * @return \Reactor\Application\ModuleConfigurator
     */
    public function init($container) {
        $configurator = parent::init($container);
        $this->dispatcher = new ContainerAwareDispatcher();
        return $configurator;
    }

    /**
     * @param \Reactor\Application\Module $container
     * @return ContainerAwareDispatcher
     * @throws \Reactor\ServiceContainer\Exceptions\ServiceNotFoundExeption
     */
    public function getService($container = null) {
        parent::getService($container);
        $this->dispatcher->setContainer($this->get('application'));
        return $this->dispatcher;
    }

    /**
     * reset dispatcher to initial state
     */
    public function reset() {
        parent::reset();
        $this->dispatcher->setContainer(null);
    }

}
