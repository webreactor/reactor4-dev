<?php

namespace Reactor\Gekkon\Module;

use \Reactor\Gekkon\TplModuleManager as OriginModuleManager;

class TplModuleManager extends OriginModuleManager {

    public function push($module) {
        if ($this->module != null) {
            $module = $this->module->resolveService($module);
        }
        array_push($this->stack, $module);
        $this->register($module);
    }

}
