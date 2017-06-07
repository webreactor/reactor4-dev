<?php

namespace MyProject;

class Application extends \Reactor\Application\Application {

    public function onLoad() {
        // $this->loadModule('db', '\Reactor\Database\PDO\Module', $container['config']['db']);
        $this->loadModule('access_control', new \Reactor\AccessControl\Module());
        $this->loadModule('dispatcher', new \Reactor\Events\Module());
        $this->loadModule('news', new \Mod\News\Module());
        
    }

}
