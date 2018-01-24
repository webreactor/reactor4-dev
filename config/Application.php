<?php

namespace MyProject;

class Application extends \Reactor\Application\Application {

    public function onLoad() {
        // $this->loadModule('db', '\Reactor\Database\PDO\Module', $container['config']['db']);
        $this->loadModule('config', new \Reactor\Application\Module());

        $this['config']['web'] = new \ArrayObject();

        // $this->loadModule('access_control', new \Reactor\AccessControl\Module());
        $this->loadModule('dispatcher', new \Reactor\Events\Module());
        // $this->loadModule('news', new \Mod\News\Module());
        $this->loadModule('web', new \Reactor\WebService\Module(), array('tree' => $this['config']['web']));
        
    }

}
