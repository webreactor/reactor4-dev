<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\Common\Tools\ArrayTools;

class ResourceLoaderManager implements ResourceLoaderInterface {

    public $loaders = array();
    public $loaded = array();

    public function load($path) {
        if (in_array($path, $this->loaded)) {
            throw new ModuleConfiguratorException("Reccursive config loading on $path");
        }
        $this->loaded[] = $path;
        if (is_dir($path)) {
            $path = realpath($path).'/';
            return $this->loadFolder($path);
        }
        return $this->loadFile($path);
    }

    protected function loadFolder($path) {
        $data = array();
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if (isset($this->loaders[$this->getExtention($file)])) {
                    $data = ArrayTools::mergeRecursive($data, $this->loadFile($path . $file));
                }
            }
            closedir($dh);
        }
        return $data;
    }

    protected function loadFile($link) {
        $ext = $this->getExtention($link);
        if (isset($this->loaders[$ext])) {
            return $this->loaders[$ext]->load($link);
        }
        throw new \Exception("Cannot find proper loader for [{$link}]", 1);
    }

    public function addLoader($ext, ResourceLoaderInterface $loader) {
        $this->loaders[$ext] = $loader;
        return $this;
    }

    public function getExtention($link) {
        return strtolower(strstr($link, '.'));
    }

}
