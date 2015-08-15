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
        $value = $this->data[$name];
        if ($value === null) {
            throw new Exceptions\ServiceNotFoundExeption($name);
        }
        if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            return $value->get($this);
        }
        return $value;
    }

    public function reset() {
        foreach ($this->data as $value) {
            if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
                $value->reset();
            }
        }
        $this->setParent(null);
    }

    public function getService($container = null) {
        $this->setParent($container);
        return $this;
    }

}
