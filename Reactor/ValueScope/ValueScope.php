<?php

namespace Reactor\ValueScope;

class ValueScope implements \IteratorAggregate {

    protected $data = array();
    protected $parent = null;

    public function getRoot() {
        if ($this->parent) {
            return $this->parent->getRoot();
        }
        return $this;
    }

    public function get($name, $default = '_throw_exception_') {
        $scope = $this->findOwner($name);
        if ($scope === null) {
            if ($default === '_throw_exception_') {
                throw new ValueNotFoundException("Not existing in the scope key [$name] ", 1);
            } else {
                return $default;
            }
        }
        return $scope->getDirect($name);
    }

    public function findOwner($name) {
        if (isset($this->data[$name])) {
            return $this;
        }
        if ($this->parent) {
            return $this->parent->findOwner($name);
        }
        return null;
    }

    public function getDirect($name) {
        return $this->data[$name];
    }

    public function hasDirect($name) {
        return isset($this->data[$name]);
    }

    public function getKeysDirect() {
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
        if ($value instanceof ValueScope) {
            $value->parent = $this;
        }
    }

    public function has($name) {
        return $this->findOwner($name) !== null;
    }

    public function setAll($values) {
        foreach ($values as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function getAll() {
        return iterator_to_array($this->getIterator(), true);
    }

    public function getIterator() {
        return new ValueScopeIterator($this);
    }

}