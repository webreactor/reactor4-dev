<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\Common\Tools\ArrayTools;

class ResourceLoaderManager implements ResourceLoaderInterface {

    public $loaders = array();
    public $loaded = array();
    public $callback = null;
    public $data = array();

    public function load($path, $callback = null) {
        $this->data = array();
        if ($callback == null) {
            $callback = array($this, 'dataCollector');
        }
        if (in_array($path, $this->loaded)) {
            throw new ModuleConfiguratorException("Reccursive config loading on $path");
        }
        $this->loaded[] = $path;
        if (is_dir($path)) {
            $path = realpath($path).'/';
            $this->loadFolder($path, $callback);
        } else {
            $this->loadFile($path, $callback);   
        }
        return $this->data;
    }

    public function dataCollector($data) {
        $this->data = ArrayTools::mergeRecursive($this->data, $data);
    }

    protected function loadFolder($path, $callback) {
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if (isset($this->loaders[$this->getExtention($file)])) {
                    $this->loadFile($path . $file, $callback);  
                }
            }
            closedir($dh);
        }
    }

    protected function loadFile($link, $callback) {
        $ext = $this->getExtention($link);
        if (isset($this->loaders[$ext])) {
            $data = $this->loaders[$ext]->load($link);
            call_user_func_array($callback, array($data));
        } else {
            throw new \Exception("Cannot find proper loader for [{$link}]", 1);    
        }
    }

    public function addLoader($ext, ResourceLoaderInterface $loader) {
        $this->loaders[$ext] = $loader;
        return $this;
    }

    public function getExtention($link) {
        return strtolower(strstr($link, '.'));
    }

}
