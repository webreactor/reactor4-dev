<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\ServiceContainer\Exceptions\ServiceConfiguratorException;
use Reactor\Common\Tools\ArrayTools;

class ResourceLoaderManager {

    public $loaders = array();
    public $loading = array();
    public $processors = array();

    public function load($path) {
        if (in_array($path, $this->loading)) {
            throw new ServiceConfiguratorException("Reccursive config loading on $path");
        }
        array_push($this->loading, $path);
        if (is_dir($path)) {
            $path = realpath($path).'/';
            $data = $this->loadFolder($path);
        } else {
            $data = $this->loadFile($path);
        }
        array_pop($this->loading);
        return $data;
    }

    public function setProcessor($name, ResourceProcessorInterface $processor) {
        $this->processors[$name] = $processor;
    }

    protected function loadFolder($path) {
        $data = array();
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if ($file[0] != '.') {
                    if (isset($this->loaders[$this->getExtention($file)])) {
                        $loaded_data = $this->loadFile($path . $file);
                        $data = ArrayTools::mergeRecursive($data, $loaded_data);
                    }
                }
            }
            closedir($dh);
        }
        return $data;
    }

    protected function loadFile($link) {
        $ext = $this->getExtention($link);
        if (isset($this->loaders[$ext])) {
            $data = $this->loaders[$ext]->load($link);
            $data = $this->process($link, $data);
        } else {
            throw new \Exception("Cannot find proper loader for [{$link}]", 1);    
        }
        return $data;
    }

    public function setLoader($ext, ResourceLoaderInterface $loader) {
        $this->loaders[$ext] = $loader;
        return $this;
    }

    public function getExtention($link) {
        return strtolower(strrchr($link, '.'));
    }

    protected function process($source, $data) {
        foreach ($this->processors as $processor) {
            $data = $processor->process($source, $data);
        }
        return $data;
    }

}
