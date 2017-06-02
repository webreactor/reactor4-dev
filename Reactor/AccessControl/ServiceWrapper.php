<?php

namespace Reactor\AccessControl;

use Reactor\Application\ServiceWrapperInterface;

class ServiceWrapper implements ServiceWrapperInterface {

    public function wrap($container, $name, $value) {
        return new Zone($name, $value);
    }

}