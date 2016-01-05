<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\ServiceContainer\Exceptions\ServiceConfiguratorException;

class ResourceLoaderJSON implements ResourceLoaderInterface {

    public function load($link) {
        if (!is_file($link)) {
            throw new ServiceConfiguratorException("ResourceLoaderJSON: Cannot find file [{$link}]");
        }
        $data = json_decode(file_get_contents($link), true);
        if ($data === null) {
            throw new ServiceConfiguratorException("ResourceLoaderJSON: Cannot parse file [{$link}]");
        }
        return $data;
    }

}
