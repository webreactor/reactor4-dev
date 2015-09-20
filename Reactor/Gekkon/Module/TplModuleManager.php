<?php

namespace Reactor\Gekkon\Module;

use \Reactor\Gekkon\TplModuleManager as OriginModuleManager;

class TplModuleManager extends OriginModuleManager {

    public function push($module) {
        if (!is_object($module)) {
            $module = $this->module->getByPath($module);
        }
        array_push($this->stack, $module);
        $this->register($module);
    }

}
