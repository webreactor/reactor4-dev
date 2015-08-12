<?php

namespace Reactor\Application;

class ConfigurationFileLoader {

    protected $configurator;

    public function __construct($configurator) {
        $this->configurator = $configurator;
    }

    public function load($file) {
        $data = json_decode(file_get_contents($file), true);
        if (isset($data['include'])) {
            $to_include = $data['include'];
            foreach ($to_include as $value) {
                $data = array_merge_recursive($data, $this->load($value));
            }
        }
        $this->configurator->load($data);
    }

}
