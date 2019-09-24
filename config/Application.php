<?php

namespace MyProject;

use Reactor\Application\YMLConfig;

class Application extends \Reactor\Application\Application {

    public function onLoad() {
        // $this->loadModule('db', '\Reactor\Database\PDO\Module', $container['config']['db']);
        $this['base_dir'] = BASE_DIR;
        $this['yml_loader'] = new YMLConfig(BASE_DIR.'var/yml_cache/');
        // $this->loadModule('access_control', new \Reactor\AccessControl\Module());
        $this->loadModule('events', new \Reactor\Events\Module());
        $web_config = array(
            'site_tree' => $this['yml_loader']->lazyLoad(__dir__.'/site_tree.yml'),
            'tpl_bin' => BASE_DIR.'var/tpl_bin/',
        );
        $this->loadModule('web', new \Reactor\WebService\Module(), $web_config);
        $this->loadModule('news', new \Mod\News\Module());
    }

}
