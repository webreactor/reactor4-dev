<?php
namespace Reactor\WebSession;

use Reactor\WebSession\Exceptions\WebSessionException;
use SessionHandlerInterface;

class Handler implements SessionHandlerInterface {
    private $storages = null;
    private $max_life_time;

    public function __construct(array $storages, $store_time = 0) {
        $this->storages = $storages;
        $this->max_life_time = $store_time;
        $this->checkExistStorage();
    }

    private function checkExistStorage() {
        if (empty($this->storages)) {
            throw new WebSessionException('You must register a key-value storage for sessions');
        }
    }

    public function close() {
        return true;
    }

    public function destroy($session_id) {
        return true;
    }

    public function gc($maxlifetime) {
        return true;
    }

    public function open($save_path, $session_id) {
        return true;
    }

    public function read($session_id) {
        foreach ($this->storages as $storage) {
            $result = $storage->get($session_id);
            if ($result !== false) {
                return (string)$result;
            }
        }
        return "";
    }

    public function write($session_id, $session_data) {
        foreach ($this->storages as $storage) {
            $storage->set($session_id, $session_data, $this->max_life_time);
        }
        return true;
    }
}
