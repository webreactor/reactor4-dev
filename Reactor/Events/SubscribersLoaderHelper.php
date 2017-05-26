<?php

namespace Reactor\Events;

use \Reactor\ServiceContainer\Reference;
use \Reactor\Application\Exceptions\ModuleConfiguratorException;

class SubscribersLoaderHelper extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $configurator = parent::configure($container, $config);
        $parent = $this->getParent();
        $module_full_name = $parent->getFullName();
        $dispatcher = $parent->get('dispatcher');

        if ($this->hasDirect('listeners')) {
            foreach ($this->getDirect('listeners') as $event => $subscribers) {
                foreach ($subscribers as $service => $method) {
                    $dispatcher->addListener($event, array(new Reference($module_full_name.'/'.$service), $method));
                }
            }
        }

        if ($this->hasDirect('subscribers')) {
            foreach ($this->getDirect('subscribers') as $subscriber) {
                $dispatcher->addSubscriberService(new Reference($module_full_name.'/'.$subscriber));
            }
        }

    }

}
