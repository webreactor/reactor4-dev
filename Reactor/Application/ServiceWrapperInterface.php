<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceProviderInterface;

interface ServiceWrapperInterface {

    public function wrap($name, $value);

}