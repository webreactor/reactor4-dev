<?php

namespace Reactor\ServiceContainer;

class Reference implements ServiceProviderInterface {

    protected $path;
    protected $loading = false;

    public function __construct($path = array()) {
        $this->path = $path;
    }

    public function getService($container = null) {
        if ($this->loading) {
            throw new Exceptions\CircularReferenceException($this->getPath());
        }
        $this->loading = true;
        $val = $container->getByPath($this->path);
        $this->loading = false;
        return $val;
    }

    public function __sleep() {}

    public function getPath() {
        return implode('/', (array)$this->path);
    }

    public static function __set_state($state) {
        return new Reference($state['path']);
    }

}
