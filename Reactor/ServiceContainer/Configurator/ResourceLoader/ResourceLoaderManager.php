<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\Common\Tools\ArrayTools;

class ResourceLoaderManager {

    public $loaders = array();
    public $loaded = array();
    public $data = array();

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

    public function dataCollector($data) {
        $data = ArrayTools::mergeRecursive($data, $imported_data);
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

    public function addLoader($ext, ResourceLoaderInterface $loader) {
        $this->loaders[$ext] = $loader;
        return $this;
    }

    public function getExtention($link) {
        return strtolower(strstr($link, '.'));
    }

    protected function process($link, $data) {
        $context = dirname($link) . '/';
        $data = $this->handleInlineImports($context, $data);
        if (isset($data['import'])) {
            foreach ($data['import'] as $import) {
                $loaded_data = $this->load($context.$import);
                $data = ArrayTools::mergeRecursive($data, $loaded_data);
            }
        }
        return $data;
    }

    protected function handleInlineImports($context, $data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (count($value) == 1 && isset($value['import'])) {
                    $imported_data = array();
                    foreach ((array)$value['import'] as $value) {
                        $loaded_data = $this->load($value);
                        $imported_data = ArrayTools::mergeRecursive($imported_data, $loaded_data);
                    }
                    $data[$key] = $imported_data;
                } else {
                    $data[$key] = $this->handleInlineImports($context, $value);
                }
            }
        }
        return $data;
    }
}
