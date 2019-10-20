<?php

namespace Reactor\ValueScope;

class NamedValueScope extends ValueScope {

    protected $name = '';

    public function set($name, $value) {
        $this->data[$name] = $value;
        if ($value instanceof NamedValueScope) {
            $value->parent = $this;
            $value->name = $name;
        }
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

    public function getFullName() {
        if ($this->parent) {
            return $this->parent->getFullName().$this->name.'/';
        }
        return '/';
    }

}