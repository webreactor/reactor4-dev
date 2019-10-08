<?php

namespace Reactor\Database;

use Reactor\Database\PDO\Connection;

class Module extends \Reactor\Application\Module {

    public function onUse() {
        foreach ($this->get('connections') as $key => $value) {
            if (!isset($value['options'])) {
                $value['options'] = array();
            }
            $this->set($key, new Connection($value['link'], $value['user'], $value['password'], $value['options']));
        }
    }

}
