<?php

namespace Reactor\Application;
use Reactor\Application\Exceptions\ModuleConfiguratorExeption;

class ConfigurationReaderJSON {

    public $file_type = '.json';
    public $loaded = array();


    public function load($path) {
        if (in_array($path, $this->loaded)) {
            throw new ModuleConfiguratorExeption("Reccursive config loading on $path");
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
                if (strstr($file, '.') == $this->file_type) {
                    $data = array_merge_recursive($data, $this->load($path.$file));
                }
            }
            closedir($dh);
        }
        return $data;
    }

    protected function loadFile($file) {
        $data = $this->loadSingleFile($file);
        $path = dirname($file).'/';
        if (isset($data['include'])) {
            $to_include = $data['include'];
            foreach ($to_include as $value) {
                $data = array_merge_recursive($data, $this->load($path.$value));
            }
        }
        return $data;
    }

    protected function loadSingleFile($file) {
        $data = json_decode(file_get_contents($file), true);
        if ($data === null) {
            throw new ModuleConfiguratorExeption("Error Processing $file");
        }
        return $data;
    }

}
