<?php

namespace Reactor\Events\Module;

use \Reactor\ServiceContainer\Reference;
use \Reactor\Application\Exceptions\ModuleConfiguratorExeption;

class SubscribersLoaderHelper extends \Reactor\Application\Module {

    protected function init() {
        $configurator = parent::init();
        $module_path = $this->getParent()->getModulePath();
        $dispatcher = $this->get('dispatcher');

        if ($this->hasDirect('listeners')) {
            foreach ($this->getDirect('listeners') as $event => $subscribers) {
                foreach ($subscribers as $service => $method) {
                    $dispatcher->addListener($event, array(new Reference($module_path.'/'.$service), $method));
                }
            }
        }

        if ($this->hasDirect('subscribers')) {
            foreach ($this->getDirect('subscribers') as $subscriber) {
                $dispatcher->addSubscriberService(new Reference($module_path.'/'.$subscriber));
            }
        }

    }

}
