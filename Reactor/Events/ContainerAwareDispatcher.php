<?php

namespace Reactor\Events;

use Reactor\ServiceContainer\ServiceProvider;

class ContainerAwareDispatcher extends Dispatcher {

    protected $container;
    
    use \Reactor\Common\Traits\Exportable;

    public function setContainer($container) {
        $this->container = $container;
    }

    protected function runCallback($callable, Event $event) {
        $obj = $this->container->resolveProviders($callable[0]);
        call_user_func(array($obj, $callable[1]), $event);
    }

    public function addSubscriberService($reference) {
        $subscriber = $this->container->resolveProviders($reference);
        if (!($subscriber instanceof SubscriberInterface)) {
            throw new \Exception("Subscriber has to implement \\Reactor\\Events\\SubscriberInterface");
        }
        foreach ($subscriber->getEventHandlers() as $event_name => $method_name) {
            $this->addListener($event_name, array($reference, $method_name));
        }
        return $this;
    }
}
