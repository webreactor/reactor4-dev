<?php

namespace Reactor\Events;

use Reactor\ServiceContainer\ServiceProvider;

/**
 * Class ContainerAwareDispatcher
 * @package Reactor\Events
 */
class ContainerAwareDispatcher extends Dispatcher {
    /**
     * @var \Reactor\Application\Module
     */
    protected $container;

    /**
     * @param $container
     */
    public function setContainer($container) {
        $this->container = $container;
    }

    /**
     * @param array $callable
     * @param Event $event
     */
    protected function runCallback($callable, Event $event) {
        $obj = $this->container->resolveProviders($callable[0]);
        call_user_func(array($obj, $callable[1]), $event);
    }

    /**
     * @param \Reactor\ServiceContainer\Reference $reference
     * @return $this
     * @throws \Exception
     */
    public function addSubscriberService($reference) {
        /** @var \Reactor\Events\SubscriberInterface $subscriber */
        $subscriber = $this->container->resolveProviders($reference);
        if (!is_a($subscriber, "\\Reactor\\Events\\SubscriberInterface")) {
            throw new \Exception("Subscriber has to implement \\Reactor\\Events\\SubscriberInterface");
        }
        foreach ($subscriber->getEventHandlers() as $event_name => $method_name) {
            $this->addListener($event_name, array($reference, $method_name));
        }
        return $this;
    }
}
