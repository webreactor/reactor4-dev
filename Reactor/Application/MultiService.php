<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceProviderInterface;

// Service that works using another services from service container

class MultiService implements ServiceProviderInterface {

    protected $is_used = false;
    protected $app = null;

    public function provideService($app) {
        if (!$this->is_used) {
            $this->is_used = true;
            $this->app = $app;
            $this->onUse();
        }
        return $this;
    }

    public function callService($path, $method = null, $args = array()) {
        return $this->app->callService($path, $method, $args);
    }

    protected function onUse() {
    }

}
