<?php

namespace MyProject;

class Application extends \Reactor\Application\Application {

    public function config() {
        $this->loadModule('db', '\Reactor\Database\PDO\Module', $container['config']['db']);

    }

}
