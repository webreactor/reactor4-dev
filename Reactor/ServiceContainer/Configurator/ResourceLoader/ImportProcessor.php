<?php

namespace Reactor\ServiceContainer\Configurator\ResourceLoader;

use Reactor\Common\Tools\ArrayTools;

class ImportProcessor implements ResourceProcessorInterface {

    protected $loader;

    public function __construct($loader) {
        $this->loader = $loader;
    }

    public function process($source, $data) {
        if (isset($data['import'])) {
            $context = dirname($source).'/';
            foreach ((array)$data['import'] as $import) {
                $loaded_data = $this->loader->load($context.$import);
                $data = ArrayTools::mergeRecursive($data, $loaded_data);
            }
        }
        return $data;
    }
}