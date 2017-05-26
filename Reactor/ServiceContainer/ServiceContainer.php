<?php

namespace Reactor\ServiceContainer;

use \Reactor\Common\ValueScope\ValueScope;

class ServiceContainer extends ValueScope {

    protected $name = '';
    protected $full_name = '/';

    public function set($name, $value) {
        $value = $this->initProviders($value);
        if ($value instanceof ServiceContainer) {
            $value->setParent($this);
            $value->setName($name);
        }
        parent::set($name, $value);
    }

    public function addAll($values) {
        foreach ($values as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function setCached($name, $value) {
        $value = $this->initProviders($value);
        if ($value instanceof ServiceProviderInterface) {
            $value = new CachedServiceProvider($value);
        }
        $this->set($name, $value);
    }

    public function get($name, $default = '_throw_exception_') {
        $value = parent::get($name, $default);
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

    protected function initProviders($value) {
        if (is_callable($value)) {
            return new CallbackServiceProvider($value);
        }
        return $value;
    }

    public function setName($name) {
        $this->name = $name;
        if ($this->parent) {
            $this->full_name = $this->parent->getFullName().$name.'/';
        } else {
            $this->full_name = '/';
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getFullName() {
        return $this->full_name;
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
        $this->set($name, $this->getReference($path));
    }

}
