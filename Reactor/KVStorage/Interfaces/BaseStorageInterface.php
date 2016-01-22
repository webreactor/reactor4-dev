<?php

namespace Reactor\KVStorage\Interfaces;

interface BaseStorageInterface {

    function get($key);
    function set($key, $value, $expiration_time);

}