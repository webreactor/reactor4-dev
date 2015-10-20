<?php

namespace Reactor\ServiceContainer\Configurator;

use Reactor\ServiceContainer\ServiceProviderInterface;

class DynamicParametersProvider implements ServiceProviderInterface {

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getService($container = null) {
        return $container->resolveProviders($this->data);
    }

    public static function __set_state($state) {
        return new self($state['data']);
    }

    public function __sleep() {
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

}
