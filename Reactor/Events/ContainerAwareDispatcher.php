<?php

namespace Reactor\Events;

use \Reactor\ServiceContainer\ServiceProviderInterface;

class ContainerAwareDispatcher extends Dispatcher {

    protected $container;
    
    public function setContainer($container) {
        $this->container = $container;
    }

    protected function runCallback($callable, Event $event) {
        if (isset($callable[0]) && $callable[0] instanceof ServiceProviderInterface) {
            $obj = $callable[0]->getService($this->container);
            call_user_func(array($obj, $callable[1]), $event);
        } else {
            parent::runCallback($callable, $event);
        }
    }

    public function addSubscriberService($path) {
        $subscriber = $this->container->getByPath($path);
        if (!($subscriber instanceof SubscriberInterface)) {
            throw new \Exception("Subscriber has to implement \\Reactor\\Events\\SubscriberInterface");
        }
        foreach ($subscriber->getEventHandlers() as $event_name => $method_name) {
            $this->addListener($event_name, array($path, $method_name));
        }
        return $this;
    }

}
