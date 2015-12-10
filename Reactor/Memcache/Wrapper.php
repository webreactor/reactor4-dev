<?php

namespace Reactor\Memcache;

class Wrapper {

    protected
        $connection = null,
        $servers = array(),
        $base_key = '';

    public function __construct($base, $servers) {
        $this->base_key = md5($base);
        $this->servers = $servers;
    }

    protected function getConnection() {
        if ($this->connection === null) {
            try {

            } catch (\Exception $ex) {

            }
        }
    }
}