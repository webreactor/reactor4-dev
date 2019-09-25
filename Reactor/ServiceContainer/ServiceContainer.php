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
            return $value->getService($this);
        }
        return $value;
    }

    public function getByPath($path = '', $default = '_throw_exception_') {
        if ($path == '') {
            return $this;
        }
        if ($path[0] === '/') {
            $value = $this->getRoot();
        } else {
            $value = $this;
        }
        $path = trim($path,'/');
        $path_words = explode('/', $path);
        $words_cnt = count($path_words);
        for ($current = 0; $current < $words_cnt; $current++) {
            $value = $value[$path_words[$current]];
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

}
