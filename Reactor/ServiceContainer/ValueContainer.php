<?php

namespace Reactor\ServiceContainer;

class ValueContainer implements \ArrayAccess {

    protected $data = array();
    protected $parent = null;

    public function setAll($data) {
        $this->data = $data;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getParent() {
        return $this->parent;
    }

    public function getKeysDirect() {
        return array_keys($this->data);
    }

    public function getRoot() {
        if ($this->parent) {
            return $this->getRoot();
        }
        return $this;
    }

    public function has($name) {
        if (isset($this->data[$name])) {
            return true;
        }
        return $this->parent !== null && $this->parent->has($name);
    }

    public function set($name, $value = null) {
        return $this->data[$name] = $value;
    }

    public function get($name) {
        if (!isset($this->data[$name])) {
            if ($this->parent !== null) {
                return $this->parent->get($name);
            }
            throw new Exceptions\ServiceNotFoundExeption($name);
        }
        return $this->getDirect($name);
    }

    public function getDirect($name) {
        return $this->data[$name];
    }

    public function remove($name) {
        unset($this->data[$name]);
    }

    public function __get($name) {
        return $this->get($name);
    }

    public function __set($name, $value) {
        return $this->set($name, $value);
    }

    public function __isset($name) {
        return $this->has($name);
    }

    public function __unset($name) {
        $this->remove($name);
    }

    public function offsetExists($name) {
        return $this->has($name);
    }

    public function offsetGet($name) {
        return $this->get($name);
    }

    public function offsetSet($name, $value) {
        return $this->set($name, $value);
    }

    public function offsetUnset($name) {
        $this->remove($name);
    }

}
