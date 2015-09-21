<?php

namespace Reactor\ServiceContainer;

/**
 * Class CachedArgsServiceFactory
 * a factory with cache for all data of given service container
 * @package Reactor\ServiceContainer
 */
class CachedArgsServiceFactory extends ArgsServiceFactory {
    /**
     * @var array
     */
    protected $cache = array();

    /**
     * @param mixed $args
     * @return mixed
     */
    public function get($args) {
        $hash = $this->getHash($args);

        if (!isset($this->cache[$hash])) {
            $this->cache[$hash] = parent::get($args);
        }

        return $this->cache[$hash];
    }

    /**
     * @param mixed $args
     * @return string
     */
    private function getHash($args) {
        return md5(serialize($args));
    }

}
