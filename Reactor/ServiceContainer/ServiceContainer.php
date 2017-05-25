<?php

namespace Reactor\ServiceContainer;

use \Reactor\Common\ValueScope\ValueScope;

class ServiceContainer extends ValueScope {

    public function set($name, $value) {
        $value = $this->initProviders($value);
        parent::set($name, $value);
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
        $path = trim($path,'/');
        if ($path == '') {
            return $this;
        }
        $path_words = explode('/', );
        $words_cnt = count($path_words);
        $value = $this;
        for ($current = 0; $current < $words_cnt; $current++) {
            $value = $value[$path_words[$current]];
        }
        return $value;
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

    protected function initProviders($value) {
        if (is_callable($value)) {
            return new CallbackServiceProvider($value);
        }
        return $value;
    }

}
