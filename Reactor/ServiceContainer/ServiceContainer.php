<?php

namespace Reactor\ServiceContainer;

use \Reactor\Common\ValueScope\ValueScope;

class ServiceContainer extends ValueScope {

    protected $name = '';

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

    public function addAll($values) {
        foreach ($values as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function getDirect($name) {
        $value = $this->data[$name];
        if ($value instanceof ServiceProviderInterface) {
            return $value->provideService($this);
        }
        return $value;
    }

    public function getByPath($path) {
        if ($path[0] == '/') {
            $value = $this->getRoot();
        } else {
            $value = $this;
        }
        $path = trim($path, '/');
        if ($path == '') {
            return $value;
        }
        foreach (explode('/', $path) as $word) {
            if ($value instanceof ValueScope) {
                $value = $value->get($word);
           } else {
                $value = $value[$word];
           }
        }
        return $value;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getFullName() {
        if ($this->parent) {
            return $this->parent->getFullName().$this->name.'/';
        }
        return '/';
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
