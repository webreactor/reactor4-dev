<?php

namespace Reactor\Common\ValueScope;

class ValueScope implements \ArrayAccess, \IteratorAggregate {

    protected $data = array();
    protected $parent = null;

    public function getParent() {
        return $this->parent;
    }

    public function getRoot() {
        if ($this->parent) {
            return $this->parent->getRoot();
        }
        return $this;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function get($name, $default = '_throw_exception_') {
        if (!isset($this->data[$name])) {
            if ($this->parent !== null) {
                $value = $this->parent->get($name, $default);
            } else {
                if ($default === '_throw_exception_') {
                    throw new ValueNotFoundException("Not existing in the scope key [$name] ", 1);
                } else {
                    $value = $default;
                }
            }
            return $value;
        }
        return $this->getDirect($name);
    }

    public function getDirect($name) {
        return $this->data[$name];
    }

    public function hasDirect($name) {
        return isset($this->data[$name]);
    }

    public function getKeysDirect($name) {
        return array_keys($this->data);
    }

    public function getKeys() {
        if ($this->parent) {
            return array_merge($this->parent->getKeys(), array_keys($this->data));
        }
        return array_keys($this->data);
    }

    public function remove($name) {
        unset($this->data[$name]);
    }

    public function removeThrough($name) {
        unset($this->data[$name]);
        if ($this->parent) {
            $this->parent->removeThrough($name);
        }
    }

    public function set($name, $value) {
        $this->data[$name] = $value;
    }

    public function has($name) {
        if (isset($this->data[$name])) {
            return true;
        }
        return $this->parent !== null && $this->parent->has($name);
    }

    public function setAll($values) {
        $this->data = $values;
    }

    public function getAll() {
        return iterator_to_array($this->getIterator(), true);
    }

    public function getIterator() {
        return new ValueScopeIterator($this);
    }

    public function offsetExists($name) {
        return $this->has($name);
    }

    public function offsetGet($name) {
        return $this->get($name);
    }

    public function offsetSet($name, $value) {
        $this->set($name, $value);
    }

    public function offsetUnset($name) {
        $this->remove($name);
    }

}
