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
        $value = call_user_func($this->callback, $container);
        if ($value instanceof ServiceProviderInterface) {
            return $value->getService($container);
        }
        return $value;
    }

}
