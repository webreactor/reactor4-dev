<?php

namespace Reactor\ServiceContainer;

/**
 * Base class for service conatainers
 * @package Reactor\ServiceContainer
 */
class ValueContainer implements \ArrayAccess {
    /**
     * @var array
     */
    protected $data = array();
    /**
     * @var mixed
     */
    protected $parent = null;

    /**
     * @param array $data
     */
    public function setAll($data) {
        $this->data = $data;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent) {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @return array
     */
    public function getKeysDirect() {
        return array_keys($this->data);
    }

    /**
     * @return $this|ValueContainer
     */
    public function getRoot() {
        if ($this->parent) {
            return $this->getRoot();
        }
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name) {
        if (isset($this->data[$name])) {
            return true;
        }
        return $this->parent !== null && $this->parent->has($name);
    }

    /**
     * set value to data element by given  name
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function set($name, $value = null) {
        return $this->data[$name] = $value;
    }

    /**
     * get value from data element by given name
     * @param string $name
     * @return mixed
     * @throws Exceptions\ServiceNotFoundExeption
     */
    public function get($name) {
        if (!isset($this->data[$name])) {
            if ($this->parent !== null) {
                return $this->parent->get($name);
            }
            throw new Exceptions\ServiceNotFoundException($name);
        }
        return $this->getDirect($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getDirect($name) {
        return $this->data[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasDirect($name) {
        return isset($this->data[$name]);
    }

    /**
     * @param string $name
     */
    public function remove($name) {
        unset($this->data[$name]);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exceptions\ServiceNotFoundExeption
     */
    public function __get($name) {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function __set($name, $value) {
        return $this->set($name, $value);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        return $this->has($name);
    }

    /**
     * @param string $name
     */
    public function __unset($name) {
        $this->remove($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function offsetExists($name) {
        return $this->has($name);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exceptions\ServiceNotFoundExeption
     */
    public function offsetGet($name) {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return null
     */
    public function offsetSet($name, $value) {
        return $this->set($name, $value);
    }

    /**
     * @param string $name
     */
    public function offsetUnset($name) {
        $this->remove($name);
    }

}
