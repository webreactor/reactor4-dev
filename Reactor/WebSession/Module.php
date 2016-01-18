<?php

namespace Reactor\WebSession;

use Reactor\WebSession\Exceptions\WebSessionException;

class Module extends \Reactor\Application\Module{

    private $handler;

    public function configure($container, $config = array()) {
        $confugurator = parent::configure($container, $config);
        if (!$this->has('storage')) {
            throw new WebSessionException('You must register a key-value storage for sessions');
        }
        $this->createService($this->get('name'), $this->get('class'), array($this->get('storage')));
        $this->handler = $this->getDirect($this->get('name'));
        if ($this->has('register') && $this->get('register')) {
            $this->register();
        }
    }
    public function register($shutdown = true) {
        session_set_save_handler($this->handler, $shutdown);
    }
}