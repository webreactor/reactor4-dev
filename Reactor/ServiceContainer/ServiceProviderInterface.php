<?php

namespace Reactor\ServiceContainer;

Interface ServiceProviderInterface {
    public function get($container);
    public function reset(); //resets internal state, usually removes shared instace
}
