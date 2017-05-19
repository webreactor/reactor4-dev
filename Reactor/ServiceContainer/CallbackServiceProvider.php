<?php

namespace Reactor\ServiceContainer;

use \Reactor\Common\ValueScope\ValueScope;
use \Reactor\Common\ValueScope\ValueNotFoundException;

class CallbackServiceProvider implements ServiceProviderInterface {
    
    protected $callback;

    function __construct($callback) {
        $this->callback = $callback;
    }

    function getService($container) {
        return call_user_func($this->callback, $container);
    }

}
