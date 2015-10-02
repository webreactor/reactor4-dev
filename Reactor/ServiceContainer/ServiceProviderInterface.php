<?php

namespace Reactor\ServiceContainer;

Interface ServiceProviderInterface {
    public function getService($container = null);
    public function __sleep(); //resets internal state, usually removes shared instace
}
