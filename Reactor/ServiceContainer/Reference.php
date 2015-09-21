<?php

namespace Reactor\ServiceContainer;

/**
 * Class Reference
 * @package Reactor\ServiceContainer
 */
class Reference implements ServiceProviderInterface {
    /**
     * @var array
     */
    protected $path;
    /**
     * @var bool
     */
    protected $loading = false;

    /**
     * @param array $path
     */
    public function __construct($path = array()) {
        $this->path = $path;
    }

    /**
     * @param ServiceContainer $container
     * @return ServiceContainer
     * @throws Exceptions\CircularReferenceExeption
     */
    public function getService($container = null) {
        if ($this->loading) {
            throw new Exceptions\CircularReferenceExeption($this->getPath());
        }
        $this->loading = true;
        $val = $container->getByPath($this->path);
        $this->loading = false;
        return $val;
    }

    /**
     * function for reset
     */
    public function reset() {}

    /**
     * @return string
     */
    public function getPath() {
        return implode('/', (array)$this->path);
    }

}
