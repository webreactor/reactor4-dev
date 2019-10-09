<?php

namespace Mod\Application;

class CliApplication extends Application {

    public function onLoad() {
        parent::onLoad();
        $this->cli = new \Reactor\Cli\Service();
        // $static_manager = new \Reactor\StaticFiles\Manager();
    }

}
