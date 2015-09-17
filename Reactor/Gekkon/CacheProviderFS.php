<?php

namespace Reactor\Gekkon;

class CacheProviderFS {
    private $baseDir;

    function __construct($baseDir) {
        $this->baseDir = $baseDir;
    }

    private function cache_dir($binTemplate) {
        return $this->baseDir . abs(crc32($binTemplate['association'])) . '/cache/';
    }

    private function cache_file($tpl_name, $id = '') {
        $name = md5($id . $tpl_name);
        return $name[0] . $name[1] . '/' . $name;
    }

    function clear_cache($binTemplate, $id = '') {
        if ($id !== '') {
            $cache_file = $this->cache_dir($binTemplate) . $this->cache_file($id);
            if (is_file($cache_file)) {
                unlink($cache_file);
            }
        } else {
            Gekkon::clear_dir($this->cache_dir($binTemplate));
        }
    }

    function save($binTemplate, $content, $id) {
        Gekkon::create_dir(dirname($cache_file = $this->cache_dir($binTemplate) . $this->cache_file($id)));
        file_put_contents($cache_file, $content);
    }

    function load($binTemplate, $id) {
        $cache_file = $this->cache_dir($binTemplate) . $this->cache_file($binTemplate['name'], $id);
        if (is_file($cache_file)) {
            return array('created' => filemtime($cache_file), 'content' => file_get_contents($cache_file));
        }
        return false;
    }
}
