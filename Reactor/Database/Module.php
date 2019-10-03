<?php

namespace Reactor\Database;

use Reactor\Database\PDO\Connection;

class Module extends \Reactor\Application\Module {

    public function onUse() {
        foreach ($this['connections'] as $key => $value) {
            $this->set($key, new Connection($value['link'], $value['user'], $value['password']));
        }
    }

}
