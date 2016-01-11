<?php

namespace Reactor\ServiceContainer;

Interface SupportsGetByPathInterface {

    public function getByPath($path, $default = null);

}
