<?php
namespace Reactor\Memcache;

class Module extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $confugurator = parent::configure($container, $config);
        foreach ($this->get('connections') as $key => $value) {
            $servers = array();
            foreach ($value as $item) {
                $servers[] = array($item['host'], $item['port']);
            }
            $this->createService($key, '\\Reactor\\Memcache\\Wrapper', array($key, $servers));
        }
    }
}
