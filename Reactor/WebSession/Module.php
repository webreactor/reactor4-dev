<?php

namespace Reactor\WebSession;

class Module extends \Reactor\Application\Module{

    public function startSession($shutdown = true) {
        session_set_save_handler($this->handler, $shutdown);
        session_start();
    }

    public function onLoad($event) {
        $this->startSession();
    }

}
