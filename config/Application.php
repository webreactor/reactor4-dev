<?php

namespace MyProject;

use Reactor\Application\YMLConfig;

class Application extends \Reactor\Application\Application {

    public function onLoad() {
        $this['yml_loader'] = new YMLConfig(BASE_DIR.'var/yml_cache/');
        $this['config'] = $this['yml_loader']->load(__dir__.'/config.yml');

        $this->loadModule('mysql', new \Reactor\Database\Module(), $this['config']['db']);
        $this['db'] = $this['mysql']['main'];

        // $this->loadModule('access_control', new \Reactor\AccessControl\Module());
        $this->loadModule('events', new \Reactor\Events\Module());
        $web_config = array(
            'site_tree' => $this['yml_loader']->lazyLoad(__dir__.'/site_tree.yml'),
            'tpl_bin' => BASE_DIR.'var/tpl_bin/',
            'base_dir' => BASE_DIR,
        );
        $this->loadModule('web', new \Reactor\WebService\Module(), $web_config);

        $this->loadModule('news', new \Mod\News\Module());
    }

}
