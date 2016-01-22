<?php

namespace Reactor\WebSession;

use Reactor\ServiceContainer\Reference;
use Reactor\WebSession\Exceptions\WebSessionException;
use Reactor\KVStorage\Interfaces\BaseStorageInterface;

class Module extends \Reactor\Application\Module{

    public function register($shutdown = true) {
       session_set_save_handler($this->handler, $shutdown);
    }

}
