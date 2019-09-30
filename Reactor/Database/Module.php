<?php

namespace Reactor\Database;

use Reactor\Application\Exceptions\ModuleConfiguratorException;

class Module extends \Reactor\Application\Module
{
    public function onUse()
    {
        foreach ($this->get('connections') as $key => $value) {
            $this->set(
                $key,
                '\\Reactor\\Database\\PDO\\Connection',
                array($value['link'], $value['user'], $value['password'])
            );
        }
    }
}
