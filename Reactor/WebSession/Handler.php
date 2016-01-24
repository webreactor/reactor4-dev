<?php
namespace Reactor\WebSession;

use Reactor\KVStorage\Interfaces\BaseStorageInterface;
use SessionHandlerInterface;

class Handler implements SessionHandlerInterface {
    private $storage = null;
    private $max_life_time;

    public function __construct(BaseStorageInterface $storage, $store_time = 0) {
        $this->storage = $storage;
        $this->max_life_time = $store_time;
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
        $result = $this->storage->get($session_id);
        if ($result !== false) {
            return (string)$result;
        }
        return "";
    }

    public function write($session_id, $session_data) {
        $this->storage->set($session_id, $session_data, $this->max_life_time);
        return true;
    }
}
