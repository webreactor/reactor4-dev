<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\Common\Tools\ArrayTools;

class InlineMergeProcessor implements ResourceProcessorInterface {

    protected $loader;

    public function __construct($loader) {
        $this->loader = $loader;
    }

    public function process($source, $data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    if (count($value) == 1 && isset($value['_merge'])) {
                        $merged_data = array();
                        $context = dirname($source).'/';
                        foreach ((array)$value['_merge'] as $value) {
                            $loaded_data = $this->loader->load($context . $value);
                            $merged_data = ArrayTools::mergeRecursive($merged_data, $loaded_data);
                        }
                        unset($data[$key]);
                        $merged_data = ArrayTools::mergeRecursive($merged_data, (array)$data);
                        return $this->process($source, $merged_data);
                    } else {
                        $data[$key] = $this->process($source, $value);
                    }
                }
            }
        }
        return $data;
    }
}
