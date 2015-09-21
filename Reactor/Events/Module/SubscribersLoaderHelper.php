<?php

namespace Reactor\Events\Module;

use \Reactor\ServiceContainer\Reference;
use \Reactor\Application\Exceptions\ModuleConfiguratorException;

/**
 * Class SubscribersLoaderHelper - helper for creating subscribers & listeners
 * @package Reactor\Events\Module
 */
class SubscribersLoaderHelper extends \Reactor\Application\Module {
    /**
     * @param \Reactor\Application\Module $container
     * @return \Reactor\Application\ModuleConfigurator
     * @throws \Exception
     * @throws \Reactor\ServiceContainer\Exceptions\ServiceNotFoundExeption
     */
    public function init($container) {
        $configurator = parent::init($container);
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
