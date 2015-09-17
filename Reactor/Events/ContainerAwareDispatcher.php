<?php

namespace Reactor\Events;

use Reactor\ServiceContainer\ServiceProvider;

class ContainerAwareDispatcher extends Dispatcher {

    protected $container;
    /**
     * @var ServiceProvider
     */
    protected $resolver;

    public function setContainer($container) {
        $this->resolver = new ServiceProvider();
        $this->container = $container;
    }

    protected function runCallback($callable, Event $event) {
        $obj = $this->resolver->resolveProviders($callable[0], $this->container);
        call_user_func(array($obj, $callable[1]), $event);
    }

    public function addSubscriberService($reference) {
        $subscriber = $this->resolver->resolveProviders($reference, $this->container);
        if (!is_a($subscriber, "\\Reactor\\Events\\SubscriberInterface")) {
            throw new \Exception("Subscriber has to implement \\Reactor\\Events\\SubscriberInterface");
        }
        foreach ($subscriber->getEventHandlers() as $event_name => $method_name) {
            $this->addListener($event_name, array($reference, $method_name));
        }
        return $this;
    }
}
