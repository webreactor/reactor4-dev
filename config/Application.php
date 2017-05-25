<?php

namespace MyProject;

class Application extends \Reactor\Application\Application {

    public function configure() {
        $container->loadModule('db', '\Reactor\Database\PDO\Module', $container['config']['db']);

    }

}
