<?php

namespace Reactor\Common\ValueScope;

class ValueScopeArray extends ValueScope implements \ArrayAccess {

    public function __construct($data = null) {
        if ($data != null) {
            $this->setAll($data);
        }
    }
    public function offsetExists($offset) {
        return $this->has($offset);
    }
    public function offsetGet($offset) {
        return $this->get($offset);
    }
    public function offsetSet($offset, $value) {
        $this->set($offset, $value);
    }
    public function offsetUnset($offset) {
        $this->remove($offset);
    }

}
