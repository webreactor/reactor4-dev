<?php

namespace Reactor\ServiceContainer;

class Reference implements ServiceProviderInterface {

    protected $name;
    protected $loading = false;

    public function __construct($name = array()) {
        if (!is_array($name)) {
            $name = explode('/', $name);
        }
        $this->name = $name;
    }

    public function getService($container = null) {
        if ($this->loading) {
            throw new Exceptions\CircularReferenceExeption(implode('/', $this->name));
        }
        $this->loading = true;
        $val = $container;

        foreach ($this->name as $service_name) {
            $val = $val->get($service_name);
        }

        $this->loading = false;
        return $val;
    }

}
