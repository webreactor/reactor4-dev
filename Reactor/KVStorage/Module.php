<?php
namespace Reactor\KVStorage;

class Module extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $confugurator = parent::configure($container, $config);
        foreach ($this->get('connections') as $key => $connection) {
            $service_class = $this->get('types')[$connection['type']];
            $this->createService($key, $service_class, array($key, $connection['servers']));
        }
    }
}
