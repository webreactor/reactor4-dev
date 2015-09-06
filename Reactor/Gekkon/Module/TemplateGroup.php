<?php

namespace Reactor\Gekkon\Module;

class TemplateGroup {

    protected $stack = array();
    public $group = null;
    protected $gekkon = null;

    function __construct($gekkon)
    {
        $this->tplProvider = $gekkon->tplProvider;
    }

    function push($group)
    {
        if (!is_object($group)) {
            $group = (new Reference($group))->getService($this->group);
        }
        array_push($this->stack, $group);
        $this->register($group);
    }

    function pop()
    {
        $group = array_pop($this->stack);
        $this->register($group);
        return $group;
    }

    function register($group) {
        $this->group = $group;
        $this->tplProvider->set_group($group->dir().'tpl/');
        $this->gekkon->data['module'] = $group;
    }

}
