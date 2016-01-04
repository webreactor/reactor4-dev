<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

class ResourceLoaderJSON implements ResourceLoaderInterface {

    public function load($link) {
        if (!is_file($link)) {
            throw new \Exception("ResourceLoaderJSON - Cannot find file [{$link}]");
        }
        $data = json_decode(file_get_contents($link), true);
        if ($data === null) {
            throw new \Exception("ResourceLoaderJSON - Cannot parse file [{$link}]");
        }
        return $data;
    }

}
