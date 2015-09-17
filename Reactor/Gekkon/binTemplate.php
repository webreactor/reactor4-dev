<?php

namespace Reactor\Gekkon;

class binTemplate extends \ArrayObject {
    var $gekkon;

    function __construct($gekkon, $template_data) {
        $this->gekkon = $gekkon;
        $this->exchangeArray($template_data);
        $block = $this['blocks']['__constructor'];
        $block($this, $this->gekkon, $this->gekkon->get_scope());
    }

    function display($scope, $block_name = '__main') {
        if (isset($this['blocks'][$block_name])) {
            $block = $this['blocks'][$block_name];
            $block($this, $this->gekkon, $scope);
        }
    }
}
