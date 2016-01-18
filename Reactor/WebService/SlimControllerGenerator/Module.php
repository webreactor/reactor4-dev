<?php

namespace Reactor\WebService\SlimControllerGenerator;

use Reactor\ServiceContainer\ServiceProvider;
use Reactor\ServiceContainer\Reference;

class Module extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $configurator = parent::configure($container, $config);
        $module_full_name = $this->getFullName();
        $generator = $this->get('generator');
        $controllers = $this->get('controllers');
        print_r($controllers);
        $this->remove('generator');
        $this->remove('controllers');
        $namespace = \str_replace('/', '\\', $module_full_name);
        foreach ($controllers as $controller_name => $definition) {
            $class_name = $namespace.'\\'.$controller_name;
            $full_class_name = $generator->generate($class_name, $definition);
            $this->createService($controller_name, $full_class_name, [ new Reference($module_full_name) ]);
        }
    }

}
