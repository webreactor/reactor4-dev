<?php

namespace Reactor\WebSession;

use Reactor\WebSession\Exceptions\WebSessionException;
use SessionHandlerInterface;

class Handler implements SessionHandlerInterface {
    private $storage = null;
    private $store_time;

    public function __construct($storage, $store_time = 0) {
        $this->storage = $storage;
        $this->store_time = $store_time;
    }

    private function checkExistStorage() {
        if ($this->storage == null) {
            throw new WebSessionException('You must register a key-value storage for sessions');
        }
    }

    public function close() {
        $this->checkExistStorage();
        return true;
    }

    public function destroy($session_id) {
        $this->checkExistStorage();
        $this->storage->delete($session_id);
    }

    public function gc($maxlifetime) {
        $this->checkExistStorage();
        return true;
    }

    public function open($save_path, $session_id) {
        $this->checkExistStorage();
        return true;
    }

    public function read($session_id) {
        $this->checkExistStorage();
        return (string)$this->storage->get($session_id);
    }

    public function write($session_id, $session_data) {
        $this->checkExistStorage();
        $this->storage->set($session_id, $session_data);
        return true;
    }
}