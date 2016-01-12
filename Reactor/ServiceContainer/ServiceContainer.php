<?php

namespace Reactor\ServiceContainer;

use \Reactor\Common\ValueScope\ValueScope;
use \Reactor\Common\Traits\Exportable;

class ServiceContainer extends ValueScope implements ServiceProviderInterface, SupportsGetByPathInterface {

    use Exportable;

    public function createService($name, $value = null, $arguments = array()) {
        if (!is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            $value = new ServiceProvider($value, $arguments);
        }
        return $this->data[$name] = $value;
    }

    public function getByPath($path = '', $default = '_throw_exception_') {
        //echo "getByPath($path)\n";
        if ($path == '') {
            return $this->getService();
        }
        $path_words = explode('/', trim($path, '/'));
        $value = $this->data;
        $resolve = true;
        while (($word = array_shift($path_words)) !== null) {
            if (is_array($value) && isset($value[$word])) {
                $value = $value[$word];
            } elseif ($this->parent !== null) {
                return $this->parent->getByPath($word.'/'.implode('/', $path_words));
            } else {
                if ($default == '_throw_exception_') {
                    throw new \Exception("Missing path: [$path]");    
                } else {
                    return $default;
                }
            }
            if (is_a($value, 'Reactor\\ServiceContainer\\SupportsGetByPathInterface')) {
                return $value->getByPath(implode('/', $path_words));
            } elseif (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
                $value = $value->getService($this);
                $resolve = false;
            }
        }
        if ($resolve) {
            return $value = $this->resolveProviders($value);    
        }
        return $value;
    }

    public function getDirect($name) {
        return $this->resolveProviders($this->data[$name]);
    }

    public function __sleep() {
        $this->setParent(null);
        ServiceContainer::sleepProviders($this->data);
    }

    static function sleepProviders($data) {
        foreach ((array)$data as $value) {
            if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
                $value->__sleep();
            } elseif (is_array($value)) {
                self::sleepProviders($value);
            }
        }
    }

    public function getService($container = null) {
        if ($container !== null) {
            $this->setParent($container);
        }
        return $this;
    }

    public function resolveProviders($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->resolveProviders($value);
            }
        } elseif (is_object($data)) {
            if (is_a($data, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
                $data = $data->getService($this);
            }
        }
        return $data;
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

}
