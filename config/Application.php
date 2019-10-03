<?php

namespace MyProject;

use Reactor\Application\YMLConfig;
use Reactor\Application\CodeCacher;

class Application extends \Reactor\Application\Application {

    public function onLoad() {
        $this['code_cacher'] = new CodeCacher(BASE_DIR.'var/code_cache/');
        $this['yml_loader'] = new YMLConfig(BASE_DIR, $this['code_cacher']);
        $this->addAll($this['yml_loader']->load('config/config.yml'));

        $this->loadModule('events', new \Reactor\Events\Module());
        $this->loadModule('mysql', new \Reactor\Database\Module());
        // $this->loadModule('access_control', new \Reactor\AccessControl\Module());
        $this->loadModule('web', new \Reactor\WebService\Module());
        $this->loadModule('news', new \Mod\News\Module());
    }

}
