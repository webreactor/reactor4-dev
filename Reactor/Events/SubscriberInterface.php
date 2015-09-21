<?php

namespace Reactor\Events;

/**
 * Interface SubscriberInterface
 * @package Reactor\Events
 */
interface SubscriberInterface {
    /**
     * @return mixed
     */
    public function getEventHandlers();
    
}
