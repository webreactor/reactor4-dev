<?php

namespace Reactor\ServiceContainer;

class ServiceContainer extends ValueContainer implements ServiceProviderInterface {

    public function createService($name, $value = null, $arguments = array()) {
        if (!is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            $value = new ServiceProvider($value, $arguments);
        }
        return $this->data[$name] = $value;
    }

    public function getDirect($name) {
        if (!isset($this->data[$name])) {
            throw new Exceptions\ServiceNotFoundExeption($name);
        }
        $value = $this->data[$name];
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

}
