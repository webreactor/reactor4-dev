<?php

namespace Reactor\Gekkon\Interfaces;

interface CacheProviderInterface {

    public function save($binTemplate, $content, $id);
    public function cache_load($binTemplate, $id);
    public function cache_created($binTemplate, $id);
    public function clear_cache($binTemplate, $id = '');

}
