<?php

namespace Reactor\ServiceContainer;

use \Reactor\ValueScope\NamedValueScope;

class ServiceContainer extends NamedValueScope {

    public function set($name, $value) {
        parent::set($name, $this->prepareValue($value));
    }

    public function setCached($name, $value) {
        $value = $this->prepareValue($value);
        parent::set($name, new CachedServiceProvider($value));
    }

    public function prepareValue($value) {
        if (is_callable($value)) {
            $value = new CallbackServiceProvider($value);
        }
        return $value;
    }

    public function getDirect($name) {
        $value = $this->data[$name];
        if ($value instanceof ServiceProviderInterface) {
            return $value->provideService($this);
        }
        return $value;
    }

    public function getReference($path = '', $local = false) {
        if ($path === '') {
            $path = $this->getFullName();
        } elseif ($path[0] != '/' && $local === false) {
            $path = $this->getFullName().$path;
        }
        return new Reference($path);
    }

    public function setReference($name, $path) {
        $this->set($name, $this->getReference($path, true));
    }

    public function __get($offset) {
        return $this->get($offset);
    }

    public function __set($offset, $value) {
        $this->set($offset, $value);
    }

}
