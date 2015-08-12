<?php

namespace Reactor\Events;

class Dispatcher {

    protected $wildcard = '#';
    protected $wordcard = '\*';
    protected $divider = '\.';
    protected $listeners = array();
    protected $cache = array();

    public function setTokens($wildcard, $wordcard, $divider = '.') {
        $this->wildcard = preg_quote($wildcard, '/');
        $this->wordcard = preg_quote($wordcard, '/');
        $this->divider = preg_quote($divider, '/');
    }

    public function addListener($event_name, $callable) {
        $this->listeners[$this->getPregMask($event_name)][] = $callable;
        $this->cache = array();
        return $this;
    }

    public function addSubscriber(SubscriberInterface $subscriber) {
        foreach ($subscriber->getEventHandlers() as $event_name => $method_name) {
            $this->addListener($event_name, array($subscriber, $method_name));
        }
        return $this;
    }

    public function dispatch(Event $event) {
        $listeners = $this->getListeners($event->getName());
        foreach ($listeners as $callback) {
            call_user_func($callback, $event);
        }
        return $this;
    }

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

    protected function getPregMask($event_mask) {
        $event_mask = preg_quote($event_mask, '/');
        $wildcard = '.+';
        $wordcard = '[^' . $this->divider . ']+';
        return '/^' . str_replace(
            array($this->wildcard, $this->wordcard),
            array($wildcard, $wordcard),
            $event_mask) . '$/';
    }

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
