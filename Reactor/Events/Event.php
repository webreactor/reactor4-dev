<?php

namespace Reactor\Events;

class Event {
    
    protected $name;
    protected $data;

    public function __construct($name, $data = null) {
        $this->name = $name;
        $this->data = $data;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getData() {
        return $this->data;
    }
    
}
