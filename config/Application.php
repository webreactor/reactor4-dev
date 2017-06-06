<?php

namespace MyProject;

class Application extends \Reactor\Application\Application {

    public function onLoad() {
        // $this->loadModule('db', '\Reactor\Database\PDO\Module', $container['config']['db']);
        $this->loadModule('access_control', '\Reactor\AccessControl\Module');
        $this->loadModule('dispatcher', '\Reactor\Events\Module');
        $this->loadModule('news', '\Mod\News\Module');
        
    }

}
