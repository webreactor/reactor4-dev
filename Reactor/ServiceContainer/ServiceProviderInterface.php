<?php

namespace Reactor\ServiceContainer;

Interface ServiceProviderInterface {

    public function getService($container = null);

    // resets internal state, usually removes shared instace
    // closes connections and etc
    public function __sleep();

}
