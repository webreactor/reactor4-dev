<?php

namespace Reactor\KVStorage;

use Predis\Client;
use Reactor\KVStorage\Exceptions\RedisException;
use Reactor\KVStorage\Interfaces\BaseStorageInterface;

class Redis implements BaseStorageInterface {
    private $connection = null, $servers = array(), $base_key = '';

    public function __construct($base, $servers) {
        $this->base_key = $base;
        $this->servers = $servers;
    }

    private function getConnection() {
        if ($this->connection === null) {
            try {
                $this->connection = new Client($this->servers);
            } catch (\Exception $ex) {
                throw new RedisException($ex->getMessage());
            }
        }
        return $this->connection;
    }

    function get($key) {
        try {
            return $this->getConnection()->get($this->base_key . $key);
        } catch (\Exception $ex) {
            throw new RedisException($ex->getMessage());
        }
    }

    function set($key, $value, $expiration_time = 0) {
        try {
            $this->getConnection()->setex($this->base_key . $key, $expiration_time, $value);
        } catch (\Exception $ex) {
            throw new RedisException($ex->getMessage());
        }
    }

    public function __get($name) {
        return $this->get($name);
    }

    public function __set($name, $value) {
        $this->set($name, $value);
    }
}
