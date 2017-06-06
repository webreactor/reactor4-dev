<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceProviderInterface;

interface ServiceWrapperInterface {

    public function wrap($container, $name, $value);

}