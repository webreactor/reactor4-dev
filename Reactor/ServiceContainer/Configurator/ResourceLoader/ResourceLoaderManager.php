<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\Common\Tools\ArrayTools;

class ResourceLoaderManager {

    public $loaders = array();
    public $loaded = array();
    public $processors = array();

    public function load($path) {
        if (in_array($path, $this->loaded)) {
            throw new ModuleConfiguratorException("Reccursive config loading on $path");
        }
        $this->loaded[] = $path;
        if (is_dir($path)) {
            $path = realpath($path).'/';
            return $this->loadFolder($path);
        } else {
            return $this->loadFile($path);   
        }
    }

    public function setProcessor($name, ResourceProcessorInterface $processor) {
        $this->processors[$name] = $processor;
    }

    protected function loadFolder($path) {
        $data = array();
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if (isset($this->loaders[$this->getExtention($file)])) {
                    $loaded_data = $this->loadFile($path . $file);
                    $data = ArrayTools::mergeRecursive($data, $loaded_data);
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
