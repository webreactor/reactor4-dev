<?php

namespace Reactor\Common\ValueScope;

class ValueScopeIterator implements \Iterator {
    
    private $position = 0;
    private $bag = null;  

    public function __construct($bag) {
        $this->bag = $bag;
        $this->keys = $bag->getKeys();
    }

    public function rewind() {
        reset($this->keys);
    }

    public function current() {
        return $this->bag->get($this->key());
    }

    public function key() {
        return current($this->keys);
    }

    public function next() {
        next($this->keys);
    }

    public function valid() {
        return $this->bag->has($this->key());
    }
}