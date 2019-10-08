<?php

namespace MyProject;

use \Reactor\Config\CodeCacher;
use \Reactor\Config\YMLConfig;

class CliApplication extends Application {

    public function onLoad() {
        parent::onLoad();
        $static_manager = new \Reactor\StaticFiles\Manager();
    }

}
