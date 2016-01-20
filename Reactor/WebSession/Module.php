<?php

namespace Reactor\WebSession;

use Reactor\ServiceContainer\Reference;
use Reactor\WebSession\Exceptions\WebSessionException;
use Reactor\Wrapper\Interfaces\BaseStorageInterface;

class Module extends \Reactor\Application\Module{

    private $handler = null;

    public function configure($container, $config = array()) {
        $confugurator = parent::configure($container, $config);
        if (!$this->has('storage')) {
            throw new WebSessionException('You must register a key-value storage for sessions');
        }
        $storage = $this->resolveProviders(new Reference('storage'));
        if (! $storage instanceof BaseStorageInterface) {
            throw new WebSessionException('Storage must to implement \\Reactor\\Wrapper\\Interfaces\\BaseStorageInterface');
        }
        $this->createService($this->name, $this->get('handler'), array($storage, $this->get('max_life_time')));
        $this->handler = $this->getDirect($this->name);
    }

    public function register($shutdown = true) {
        if ($this->handler != null) {
            session_set_save_handler($this->handler, $shutdown);
        }
    }
}