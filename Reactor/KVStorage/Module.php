<?php
namespace Reactor\KVStorage;

use Reactor\ServiceContainer\Reference;

class Module extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $confugurator = parent::configure($container, $config);
        foreach ($this->get('services') as $name => $service) {
            foreach ($service['connections'] as $key => $connection) {
                $serv = $this->resolveProviders(new Reference($connection['type']));
                $this->createService($key, get_class($serv), array($key, $connection));
            }
        }
    }
}
