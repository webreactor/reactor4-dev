<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class ResourceLoaderYAML implements ResourceLoaderInterface {

    public function load($link) {
        if (!is_file($link)) {
            throw new \Exception("ResourceLoaderYAML: Cannot find file [{$link}]");
        }
        try {
            return Yaml::parse(file_get_contents($link), true);
        } catch (\Exception $e) {
            throw new \Exception("ResourceLoaderYAML: Cannot parse file [{$link}], with message: ".$e->getMessage());
        }
    }

}
