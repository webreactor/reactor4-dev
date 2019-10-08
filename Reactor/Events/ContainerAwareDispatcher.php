<?php

namespace Reactor\Events;

use \Reactor\ServiceContainer\ServiceProviderInterface;

class ContainerAwareDispatcher extends Dispatcher implements ServiceProviderInterface {

    protected $is_used = false;
    protected $app;
    
    public function provideService($app) {
        if ($this->is_used === false) {
            $this->is_used = true;
            $this->app = $app;
        }
        return $this;
    }

    protected function runCallback($callable, Event $event) {
        $this->app->callService($callable[0], $callable[1], array($event));
    }

}
