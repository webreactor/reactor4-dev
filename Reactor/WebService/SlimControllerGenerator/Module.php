<?php

namespace Reactor\WebService\SlimControllerGenerator;

use Reactor\ServiceContainer\ServiceProvider;
use Reactor\ServiceContainer\Reference;

class Module extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $configurator = parent::configure($container, $config);
        $module_full_name = $this->getParent()->getFullName();
        $generator = $this->get('generator');
        $controllers = $this->get('controllers');
        $this->remove('generator');
        $this->remove('controllers');
        foreach ($controllers as $service_name => $definition) {
            $class_name = $generator->generate($definition);
            $service = new ServiceProvider($class_name, [ new Reference($module_full_name) ]);
            $this->set($service_name, $service);
        }
    }

}
