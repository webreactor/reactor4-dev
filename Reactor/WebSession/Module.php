<?php
namespace Reactor\WebSession;

use Reactor\KVStorage\Interfaces\BaseStorageInterface;
use Reactor\ServiceContainer\Reference;
use Reactor\WebSession\Exceptions\WebSessionException;

class Module extends \Reactor\Application\Module {
    private $handler = null;

    public function configure($container, $config = array()) {
        $confugurator = parent::configure($container, $config);
        if (!$this->has('storages')) {
            throw new WebSessionException('You must register a key-value storage for sessions');
        }
        $storages = $this->resolveProviders(new Reference('storages'));
        if (!$storages instanceof BaseStorageInterface) {
            throw new WebSessionException('Storage must to implement \\Reactor\\KVStorage\\Interfaces\\BaseStorageInterface');
        }
        $this->createService($this->name, '\\Reactor\\WebSession\\Handler', array($storage, $this->get('max_life_time')));
        $this->handler = $this->getDirect($this->name);
    }

    public function register($shutdown = true) {
        if ($this->handler != null) {
            session_set_save_handler($this->handler, $shutdown);
        }
    }
}
