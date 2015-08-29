<?php

namespace Reactor\ServiceContainer;

class EnvironmentReference implements ServiceProviderInterface {

    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getService($container = null) {
        return getenv($this->name);
    }

    public function reset() {}

}
