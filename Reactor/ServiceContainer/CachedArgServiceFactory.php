<?php

namespace Reactor\ServiceContainer;

/**
 * Class CachedArgServiceFactory
 * a factory with cache for dynamic argument of given service container
 * @package Reactor\ServiceContainer
 */
class CachedArgServiceFactory extends ArgsServiceFactory {
    /**
     * @var array
     */
    protected $cache = array();

    /**
     * @param mixed $argument
     * @return mixed
     */
    public function get($argument) {
        if (!isset($this->cache[$argument])) {
            $this->cache[$argument] = parent::get(array('dynamic-argument' => $argument));
        }

        return $this->cache[$argument];
    }

}
