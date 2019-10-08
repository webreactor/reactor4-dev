<?php

namespace Reactor\Gekkon\Module;

use \Reactor\Application\MultiService;
use Reactor\Gekkon\Gekkon;

class Service extends MultiService {

    protected $gekkon;

    public function onUse() {
        $this->gekkon = new Gekkon(BASE_DIR, $this->app->get('tpl_bin'));
        $this->gekkon->tpl_module_manager = new TplModuleManager($this->gekkon);
        $this->gekkon->tpl_module_manager->push($this->app);
        $this->gekkon->tpl_provider = new TplProviderReactorMod($this->app);
    }

    public function provideService($container = null) {
        parent::provideService($container);
        return $this->gekkon;
    }

}
