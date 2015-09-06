<?php

namespace Reactor\Gekkon;

class TplModuleManager {

    protected $stack = array();
    protected $tplProvider = null;
    public $module;

    function __construct($gekkon)
    {
        $this->tplProvider = $gekkon->tplProvider;
    }

    function push($module)
    {
        array_push($this->stack, $module);
        $this->module = $module;
        $this->tplProvider->set_module($module);
    }

    function pop()
    {
        $module = array_pop($this->stack);
        $this->module = $module;
        $this->tplProvider->set_module($module);
    }

}
