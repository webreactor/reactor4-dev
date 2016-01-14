<?php

namespace Reactor\Gekkon\Module;

use \Reactor\Application\Exceptions\ModuleConfiguratorException;

class Module extends \Reactor\Application\Module {

    public function getService($container = null) {
        parent::getService($container);
        return $this->get('gekkon');
    }

}
