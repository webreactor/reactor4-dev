<?php

namespace Reactor\WebService;

use \Reactor\Application\Multiservice;

class WebSession extends Multiservice {

    public function __construct() {
        if (isset($request->cookie[session_name()])) {
            $this->start();
        }
    }

    public function start() {
        if (session_id() === '') {
            session_start();
        }
    }

    public function offsetExists($offset) {
        $this->start();
        return isset($_SESSION[$offset]);
    }

    public function offsetGet($offset) {
        $this->start();
        return $_SESSION[$offset];
    }

    public function offsetSet($offset, $value) {
        $this->start();
        return $_SESSION[$offset] = $value;
    }

    public function offsetUnset($offset) {
        $this->start();
        unset($_SESSION[$offset]);
    }

    public function getCollection($name) {
        $this->start();
        if (!isset($_SESSION[$name])) {
            $_SESSION[$name] = new \ArrayObject();
        }
        return $_SESSION[$name];
    }

}
