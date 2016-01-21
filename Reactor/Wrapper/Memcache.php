<?php

namespace Reactor\Wrapper;

use Reactor\Wrapper\Exceptions\MemcacheException;
use Reactor\Wrapper\Interfaces\BaseStorageInterface;

class Memcache implements BaseStorageInterface {

    protected
        $connection = null,
        $servers = array(),
        $base_key = '';

    public function __construct($base, $servers) {
        $this->base_key = $base;
        $this->servers = $servers;
    }

    protected function getConnection() {
        if ($this->connection === null) {
            try {
                $this->connection = new \Memcached();
                foreach($this->servers as $server) {
                    $this->connection->addServer($server["host"], $server["port"]);
                }
            } catch (\Exception $ex) {
                throw new MemcacheException($ex->getMessage());
            }
        }
        return $this->connection;
    }

    public function get($key) {
        try {
            return $this->getConnection()->get($this->base_key . $key);
        } catch (\Exception $ex) {
            throw new MemcacheException($ex->getMessage());
        }
    }

    public function set($key, $value, $expiration_time = 0) {
        try {
            $this->getConnection()->set($this->base_key . $key, $value, $expiration_time);
        } catch (\Exception $ex) {
            throw new MemcacheException($ex->getMessage());
        }
    }

    public function __get($name) {
        return $this->get($name);
    }

    public function __set($name, $value) {
        $this->set($name, $value);
    }

}
