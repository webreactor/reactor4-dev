<?php

namespace Reactor\ServiceContainer;

use \Reactor\ValueScope\ValueScope;
use \Reactor\ValueScope\ValueNotFoundException;

class CallbackServiceProvider implements ServiceProviderInterface {
    
    protected $callback;

    function __construct($callback) {
        $this->callback = $callback;
    }

    function provideService($container) {
        $value = call_user_func($this->callback, $container);
        if ($value instanceof ServiceProviderInterface) {
            return $value->provideService($container);
        }
        return $value;
    }

}
