<?php

namespace Reactor\Common\ValueScope;

class ValueScopeArray {

    public static function create($data = null) {
        if ($data !== null) {
            if (!($data instanceof ValueScope)) {
                $class = get_class($this);
                $parent = new $class();
                $parent->setAll($data);
            }
            $this->setParent($parent);
        }
    }

}

