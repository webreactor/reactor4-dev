<?php

namespace Reactor\Events\Module;

use \Reactor\ServiceContainer\Reference;
use \Reactor\Application\Exceptions\ModuleConfiguratorException;

class SubscribersLoaderHelper extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $configurator = parent::configure($container, $config);
        $module_full_name = $this->getParent()->getFullName();
        $dispatcher = $this->get('dispatcher');

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
