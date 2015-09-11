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
            throw new Exceptions\CircularReferenceExeption($this->getPath());
        }
        $this->loading = true;
        $val = $container->getByPath($this->path);
        $this->loading = false;
        return $val;
    }

    public function reset() {}

    public function getPath() {
        return implode('/', (array)$this->path);
    }

}
