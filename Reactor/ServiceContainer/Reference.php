<?php

namespace Reactor\ServiceContainer;

class Reference implements ServiceProviderInterface {

    protected $path;
    protected $loading = false;

    public function __construct($path = '') {
        $this->path = $path;
    }

    public function getService($container = null) {
        if ($this->loading) {
            throw new Exceptions\CircularReferenceException("Circular reference [{$this->path}]");
        }
        $this->loading = true;
        $val = $container->getByPath($this->path);
        $this->loading = false;
        return $val;
    }

    public function __sleep() {}

    public static function __set_state($state) {
        return new Reference($state['path']);
    }

}
