<?php

namespace Mod\Application;

use \Reactor\Config\CodeCacher;
use \Reactor\Config\YMLConfig;

class WebApplication extends \Reactor\Application\Application {

    public function onLoad() {
        $this->code_cacher = new CodeCacher(BASE_DIR . 'var/code_cache/');
        $this->yml = $yml = new YMLConfig(BASE_DIR, $this->get('code_cacher'));
        $this->setAll($yml->load('config/config.yml'));

        $this->events = new \Reactor\Events\ContainerAwareDispatcher();
        $this->mysql = new \Reactor\Database\Module();
        // $this->loadModule('access_control', new \Reactor\AccessControl\Module());
        $this->web = new \Reactor\WebService\Module();
        $this->news = new \Mod\News\Module();
    }

}
