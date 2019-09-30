<?php

namespace Reactor\Gekkon\Module;

use Reactor\Gekkon\Gekkon;

class Service extends \Reactor\Application\MultiService {

    protected $gekkon;

    public function onUse() {
        $this->gekkon = new Gekkon($this->app['base_dir'], $this->app['tpl_bin']);
        $this->gekkon->tpl_module_manager = new TplModuleManager($this->gekkon);
        $this->gekkon->tpl_module_manager->push($this->app);
        $this->gekkon->tpl_provider = new TplProviderReactorMod($this->app);
    }

    public function getService($container = null) {
        parent::getService($container);
        return $this->gekkon;
    }

}
