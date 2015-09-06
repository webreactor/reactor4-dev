<?php

namespace Reactor\Gekkon;

class TemplateGroup {

    protected $stack = array();
    protected $tplProvider = null;
    public $group;

    function __construct($gekkon)
    {
        $this->tplProvider = $gekkon->tplProvider;
    }

    function push($group)
    {
        array_push($this->stack, $group);
        $this->group = $group;
        $this->tplProvider->set_group($group);
    }

    function pop()
    {
        $group = array_pop($this->stack);
        $this->group = $group;
        $this->tplProvider->set_group($group);
    }

}
