<?php

namespace Reactor\ServiceContainer;

use \Reactor\Common\ValueScope\ValueScope;
use \Reactor\Common\ValueScope\ValueNotFoundException;
use \Reactor\Common\Traits\Exportable;

class ServiceContainer extends ValueScope implements ServiceProviderInterface, SupportsGetByPathInterface {

    use Exportable;

    public function createService($name, $value = null, $arguments = array()) {
        if (!($value instanceof ServiceProviderInterface)) {
            $value = new ServiceProvider($value, $arguments);
        }
        return $this->data[$name] = $value;
    }

    public function getByPath($path = '', $default = '_throw_exception_') {
        //echo "getByPath($path)\n";
        $path = trim($path,'/ ');
        if ($path == '') {
            return $this->getService();
        }
        $path_words = explode('/', $path);
        if (count($path_words) == 1) {
            return $this->get($path);
        }
        $value = &$this->data;
        $local_context = true;
        while (($word = current($path_words)) !== false) {
            if ($value instanceof SupportsGetByPathInterface) {
                return $value->getByPath(implode('/', $path_words));
            }
            if ((is_array($value) || $value instanceof \ArrayAccess) && isset($value[$word])) {
                $value = &$value[$word];
            } elseif ($this->parent !== null) {
                return $this->parent->getByPath(implode('/', $path_words));
            } else {
                if ($default === '_throw_exception_') {
                    throw new ValueNotFoundException("Missing path: [$path]");
                } else {
                    return $default;
                }
            }
            if ($local_context && $value instanceof ServiceProviderInterface) {
                $value = $value->getService($this);
                $local_context = false;
            }
            array_shift($path_words);
        }
        if ($local_context) {
            return $this->resolveProviders($value);
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
            if ($value instanceof ServiceProviderInterface) {
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
            if ($data instanceof ServiceProviderInterface) {
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
