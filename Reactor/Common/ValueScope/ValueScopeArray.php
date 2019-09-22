<?php

namespace Reactor\Common\ValueScope;

class ValueScopeArray extends ValueScope {

    public function __construct($data = null) {
        if ($data != null) {
            $this->setAll($data);
        }
    }

}

