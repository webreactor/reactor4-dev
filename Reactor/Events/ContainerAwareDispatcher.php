<?php

namespace Reactor\Events;

use \Reactor\ServiceContainer\ServiceProviderInterface;

class ContainerAwareDispatcher extends Dispatcher {

    protected $container;
    
    public function setContainer($container) {
        $this->container = $container;
    }

    protected function runCallback($callable, Event $event) {
        if (isset($callable[0])) {
            $obj = $this->container->resolveService($callable[0]);
            call_user_func(array($obj, $callable[1]), $event);
        } else {
            parent::runCallback($callable, $event);
        }
    }

    public function addSubscriber($path_or_service) {
        $subscriber = $this->container->resolveService($path_or_service);
        return parent::addSubscriber($subscriber);
    }

}
