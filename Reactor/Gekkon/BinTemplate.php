<?php

namespace Reactor\Gekkon;

class BinTemplate extends \ArrayObject {

    public $gekkon;
    public $module;

    public function __construct($template_data, $gekkon, $module) {
        $this->gekkon = $gekkon;
        $this->module = $module;
        $this->exchangeArray($template_data);
        $block = $this['blocks']['__constructor'];
        $block($gekkon->get_scope(), $gekkon, $this);
    }

    public function display($scope, $block_name = '__main') {
        if (isset($this['blocks'][$block_name])) {
            $block = $this['blocks'][$block_name];
            $block($scope, $this->gekkon, $this);
        }
    }

}
