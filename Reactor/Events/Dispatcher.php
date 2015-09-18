<?php

namespace Reactor\Events;

/**
 * Class Dispatcher
 * @package Reactor\Events
 */
class Dispatcher {
    /**
     * @var string
     */
    protected $wildcard = '#';
    /**
     * @var string
     */
    protected $wordcard = '\*';
    /**
     * @var string
     */
    protected $divider = '\.';
    /**
     * @var array
     */
    protected $listeners = array();
    /**
     * @var array
     */
    protected $cache = array();

    /**
     * @param $wildcard
     * @param $wordcard
     * @param string $divider
     */
    public function setTokens($wildcard, $wordcard, $divider = '.') {
        $this->wildcard = preg_quote($wildcard, '/');
        $this->wordcard = preg_quote($wordcard, '/');
        $this->divider = preg_quote($divider, '/');
    }

    /**
     * @param $event_name
     * @param $callable
     * @return $this
     */
    public function addListener($event_name, $callable) {
        $this->listeners[$this->getPregMask($event_name)][] = $callable;
        $this->resetCache();
        return $this;
    }

    /**
     *
     */
    public function resetCache() {
        $this->cache = array();
    }

    /**
     * @param SubscriberInterface $subscriber
     * @return $this
     */
    public function addSubscriber(SubscriberInterface $subscriber) {
        foreach ($subscriber->getEventHandlers() as $event_name => $method_name) {
            $this->addListener($event_name, array($subscriber, $method_name));
        }
        return $this;
    }

    /**
     * @param $name
     * @param null $data
     */
    public function raise($name, $data = null) {
        $this->dispatch(new Event($name, $data));
    }

    /**
     * @param Event $event
     * @return $this
     */
    public function dispatch(Event $event) {
        $listeners = $this->getListeners($event->getName());
        foreach ($listeners as $callable) {
            $this->runCallback($callable, $event);
        }
        return $this;
    }

    /**
     * @param $callable
     * @param Event $event
     */
    protected function runCallback($callable, Event $event) {
        call_user_func($callable, $event);
    }

    /**
     * @param $event_name
     * @return array
     */
    public function getListeners($event_name) {
        if (isset($this->cache[$event_name])) {
            return $this->cache[$event_name];
        }
        $matched_listeners = array();
        foreach ($this->listeners as $mask => $listeners) {
            if (preg_match($mask, $event_name)) {
                $matched_listeners = array_merge($matched_listeners, $listeners);
            }
        }
        $this->cache[$event_name] = $matched_listeners;
        return $matched_listeners;
    }

    /**
     * @param $event_mask
     * @return string
     */
    protected function getPregMask($event_mask) {
        $event_mask = preg_quote($event_mask, '/');
        $wildcard = '.+';
        $wordcard = '[^' . $this->divider . ']+';
        return '/^' . str_replace(
            array($this->wildcard, $this->wordcard),
            array($wildcard, $wordcard),
            $event_mask) . '$/';
    }

    /**
     * @param $event_name
     * @return array
     */
    protected function getSuperEventNames($event_name) {
        $super_names = array($event_name);
        $divider_pos = strrpos($event_name, $this->divider);
        while ($divider_pos !== false) {
            $event_name = substr($event_name, 0, $divider_pos);
            $super_names[] = $event_name . $this->divider . $this->wildcard;
            $divider_pos = strrpos($event_name, $this->divider);
        }
        $super_names[] = $this->wildcard;
        return $super_names;
    }

}
