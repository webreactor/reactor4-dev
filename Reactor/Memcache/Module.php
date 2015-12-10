<?php
namespace Reactor\Memcache;

class Module extends \Reactor\Application\Module {

    public function init($container, $config = array()) {
        $confugurator = parent::init($container, $config);
        foreach ($this->data as $key => $value) {
            $servers = array();
            foreach ($value as $item) {
                $servers[] = array($item['host'], $item['port']);
            }
            $this->createService($key, '\\Reactor\\Memcache\\Wrapper', array($key, $servers));
        }
    }
}