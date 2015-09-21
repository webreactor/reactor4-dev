<?php

namespace Reactor\ServiceContainer;

/**
 * Class ServiceContainer
 * a main class for all services
 * @package Reactor\ServiceContainer
 */
class ServiceContainer extends ValueContainer implements ServiceProviderInterface {
    /**
     * @param string $name
     * @param mixed $value
     * @param array $arguments
     * @return ServiceProviderInterface
     */
    public function createService($name, $value = null, $arguments = array()) {
        if (!is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
            $value = new ServiceProvider($value, $arguments);
        }
        return $this->data[$name] = $value;
    }

    /**
     * @param string|array $path
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

    /**
     * @param string $name
     * @return ServiceProviderInterface
     * @throws Exceptions\ServiceNotFoundExeption
     */
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

    /**
     * function for reset
     */
    public function reset() {
        $this->_reset($this->data);
        $this->setParent(null);
    }

    /**
     * @param array $data
     */
    protected function _reset($data) {
        foreach ($data as $value) {
            if (is_a($value, 'Reactor\\ServiceContainer\\ServiceProviderInterface')) {
                /** @var ServiceProviderInterface $value */
                $value->reset();
            } elseif (is_array($value)) {
                $this->_reset($value);
            }
        }
    }

    /**
     * @param ServiceContainer $container
     * @return $this
     */
    public function getService($container = null) {
        $this->setParent($container);
        return $this;
    }

    /**
     * @param mixed $data
     * @return mixed
     */
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
