<?php

namespace Reactor\Events;

/**
 * Class Event
 * @package Reactor\Events
 */
class Event {
    /**
     * @var
     */
    protected $name;
    /**
     * @var null
     */
    protected $data;

    /**
     * @param $name
     * @param null $data
     */
    public function __construct($name, $data = null) {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getData() {
        return $this->data;
    }
    
}
