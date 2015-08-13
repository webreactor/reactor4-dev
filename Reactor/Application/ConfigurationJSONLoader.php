<?php

namespace Reactor\Application;

class ConfigurationJSONLoader {

    public function load($file) {
        $data = $this->loadFile($file);
        $path = dirname($file).'/';
        if (isset($data['include'])) {
            $to_include = $data['include'];
            foreach ($to_include as $value) {
                $data = array_merge_recursive($data, $this->load($path.$value));
            }
        }
        return $data;
    }

    protected function loadFile($file) {
        return json_decode(file_get_contents($file), true);
    }

}
