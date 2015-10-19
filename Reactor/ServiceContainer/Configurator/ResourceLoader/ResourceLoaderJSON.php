<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

class ResourceLoaderJSON implements ResourceLoaderInterface {

    public function load($link) {
        if (!is_file($link)) {
            throw new \Exception("ResourceLoaderJSON - Cannot find file [{$link}]");    
        }
        return json_decode(file_get_contents($link), true);
    }

}
