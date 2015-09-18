<?php

namespace Reactor\ServiceContainer;

class ServiceContainer extends ValueContainer implements ServiceProviderInterface {

    public function createService($name, $value = null, $arguments = array()) {
        if (!is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            $value = new ServiceProvider($value, $arguments);
        }
        return $this->data[$name] = $value;
    }

    /**
     * @param $path
     * @return ServiceContainer
     */
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
        if (!isset($this->data[$name])) {
            throw new Exceptions\ServiceNotFoundExeption($name);
        }
        $value = $this->data[$name];
        /** @var ServiceProviderInterface $value */
        if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            return $value->getService($this);
        }
        return $value;
    }

    public function reset() {
        $this->_reset($this->data);
        $this->setParent(null);
    }

    protected function _reset($data) {
        /** @var ServiceProviderInterface $value */
        foreach ($data as $value) {
            if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
                $value->reset();
            } elseif (is_array($value)) {
                $this->_reset($value);
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

}
