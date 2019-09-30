<?php

namespace Reactor\Common\Tools;

class HandyArray extends \ArrayObject {

    public function get($name, $default, $if_empty = false) {
        if (!isset($this[$name]) || ($if_empty && empty($this[$name]))) {
            return $default;
        }
        return $this[$name];
    }

}
