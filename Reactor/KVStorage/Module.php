<?php
namespace Reactor\KVStorage;

class Module extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $confugurator = parent::configure($container, $config);
        foreach ($this->get('services') as $name => $service) {
            foreach ($service['connections'] as $key => $connection) {
                $this->createService($key, $service['class'], array($key, $connection));
            }
        }
    }
}