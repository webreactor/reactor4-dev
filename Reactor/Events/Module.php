<?php

namespace Reactor\Events;

use \Reactor\Events\ContainerAwareDispatcher;

class Module extends \Reactor\Application\Module {

    protected $dispatcher;

    public function init() {
        $this->dispatcher = new ContainerAwareDispatcher();
        $this->dispatcher->setContainer($this);
    }

    public function getService($container = null) {
        parent::getService($container);
        return $this->dispatcher;
    }

}
