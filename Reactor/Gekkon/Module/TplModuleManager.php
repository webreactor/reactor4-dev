<?php

namespace Reactor\Gekkon\Module;
use \Reactor\ServiceContainer\Reference;

class TplModuleManager {

    protected $stack = array();
    protected $module = null;
    protected $gekkon = null;

    public function __construct($gekkon) {
        $this->tplProvider = $gekkon->tplProvider;
        $this->gekkon = $gekkon;
    }

    public function push($module) {
        if (!is_object($module)) {
            $module = (new Reference($module))->getService($this->module);
        }
        array_push($this->stack, $module);
        $this->register($module);
    }

    public function pop() {
        $module = array_pop($this->stack);
        $this->register($module);
        return $module;
    }

    protected function register($module) {
        $this->module = $module;
        $this->tplProvider->set_module($module->dir().'tpl/');
        $this->gekkon->data['_module'] = $module;
    }

}
