<?php

namespace Reactor\Events;

/**
 * Class Event
 * base class for all events
 * @package Reactor\Events
 */
class Event {
    /**
     * event name
     * @var string
     */
    protected $name;
    /**
     * event data
     * @var mixed
     */
    protected $data;

    /**
     * @param string $name
     * @param mixed $data
     */
    public function __construct($name, $data = null) {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * get event name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * get event data
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }
    
}
