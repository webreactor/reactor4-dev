<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

class InlineImportProcessor implements ResourceProcessorInterface {

    protected $loader;

    public function __construct($loader) {
        $this->loader = $loader;
    }

    public function process($source, $data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    if (count($value) == 1 && isset($value['import'])) {
                        $imported_data = array();
                        $context = dirname($source).'/';
                        foreach ((array)$value['import'] as $value) {
                            $loaded_data = $this->loader->load($context . $value);
                            $imported_data = ArrayTools::mergeRecursive($imported_data, $loaded_data);
                        }
                        $data[$key] = $imported_data;
                    } else {
                        $data[$key] = $this->process($source, $value);
                    }
                }
            }
        }
        return $data;
    }
}
