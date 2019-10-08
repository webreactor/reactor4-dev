<?php

namespace MyProject;

use \Reactor\Config\CodeCacher;
use \Reactor\Config\YMLConfig;

class Application extends \Reactor\Application\Application {

    public function onLoad() {
        $this->set('code_cacher', new CodeCacher(BASE_DIR . 'var/code_cache/'));
        $this->set('yml_loader', $yml_loader = new YMLConfig(BASE_DIR, $this->get('code_cacher')));
        $this->addAll($yml_loader->load('config/config.yml'));

        $this->set('events', new \Reactor\Events\ContainerAwareDispatcher());
        $this->loadModule('mysql', new \Reactor\Database\Module());
        // $this->loadModule('access_control', new \Reactor\AccessControl\Module());
        $this->loadModule('web', new \Reactor\WebService\Module());
        $this->loadModule('news', new \Mod\News\Module());
    }

}
