<?php

namespace Reactor\ServiceContainer;

Interface ServiceProviderInterface {
    public function getService($container = null);
    public function reset(); //resets internal state, usually removes shared instace
}
