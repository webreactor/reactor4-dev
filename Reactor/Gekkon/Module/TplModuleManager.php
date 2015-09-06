<?php

namespace Reactor\Gekkon\Module;

class TplModuleManager {

    protected $stack = array();
    public $module = null;
    protected $gekkon = null;

    function __construct($gekkon)
    {
        $this->tplProvider = $gekkon->tplProvider;
        $this->gekkon = $gekkon;
    }

    function push($module)
    {
        if (!is_object($module)) {
            $module = (new Reference($module))->getService($this->module);
        }
        array_push($this->stack, $module);
        $this->register($module);
    }

    function pop()
    {
        $module = array_pop($this->stack);
        $this->register($module);
        return $module;
    }

    function register($module) {
        $this->module = $module;
        $this->tplProvider->set_module($module->dir().'tpl/');
        $this->gekkon->data['_module'] = $module;
    }

}
