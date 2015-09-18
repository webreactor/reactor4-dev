<?php

namespace Reactor\Database;

use Reactor\Application\Exceptions\ModuleConfiguratorException;

class Module extends \Reactor\Application\Module {
    public function init($container) {
        $confugurator = parent::init($container);
        foreach ($this->data as $key => $value) {
            $this->createService($key, '\\Reactor\\Database\\PDO\\Connection', array($value['link'], $value['user'], $value['password']));
        }
    }
}
