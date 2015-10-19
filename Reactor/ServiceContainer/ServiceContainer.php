<?php

namespace Reactor\ServiceContainer;

use \Reactor\Common\ValueScope\ValueScope;
use \Reactor\Common\Traits\Exportable;

class ServiceContainer extends ValueScope implements ServiceProviderInterface {

    use Exportable;

    public function createService($name, $value = null, $arguments = array()) {
        if (!is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            $value = new ServiceProvider($value, $arguments);
        }
        return $this->data[$name] = $value;
    }

    public function getByPath($path) {
        if (!is_array($path)) {
            $path = explode('/', trim($path, '/'));
        }
        $value = $this;
        $cnt = count($path);
        for ($i = 0; $i < $cnt; $i++) {
            $value = $value[$path[$i]];
        }
        return $value;
    }

    public function getDirect($name) {
        $value = $this->data[$name];
        if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            return $value->getService($this);
        }
        return $value;
    }

    public function __sleep() {
        $this->setParent(null);
        $this->sleepProviders($this->data);
    }

    protected function sleepProviders($data) {
        foreach ($data as $value) {
            if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
                $value->__sleep();
            } elseif (is_array($value)) {
                $this->sleepProviders($value);
            }
        }
    }

    public function getService($container = null) {
        $this->setParent($container);
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
