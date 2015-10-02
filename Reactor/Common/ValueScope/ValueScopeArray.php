<?php

namespace Reactor\Common\ValueScope;

class ValueScopeArray extends ValueScope {

    public function __construct($data = null) {
        if ($data !== null) {
            if (!is_a($data, 'Reactor\\Common\\ValueScope')) {
                $class = get_class($this);
                $parent = new $class();
                $parent->setAll($data);
            }
            $this->setParent($parent);
        }
    }

}

