<?php

namespace Reactor\Gekkon;

use Reactor\Gekkon\Interfaces\CacheProviderInterface;

class CacheProviderFS implements CacheProviderInterface {
    protected $baseDir;

    public function __construct($baseDir) {
        $this->baseDir = $baseDir;
    }

    protected function cache_dir($binTemplate) {
        return $this->baseDir . abs(crc32($binTemplate['id'])) . '/cache/';
    }

    protected function cache_file($tpl_name, $id = '') {
        $name = md5($id . $tpl_name);
        return $name[0] . $name[1] . '/' . $name.'.php';
    }

    public function clear_cache($binTemplate, $id = null) {
        if ($id !== null) {
            $cache_file = $this->cache_dir($binTemplate) . $this->cache_file($id);
            if (is_file($cache_file)) {
                unlink($cache_file);
            }
        } else {
            Gekkon::clear_dir($this->cache_dir($binTemplate));
        }
    }

    public function save($binTemplate, $content, $id) {
        $cache_file = $this->cache_dir($binTemplate) . $this->cache_file($binTemplate['id'], $id);
        Gekkon::create_dir(dirname($cache_file));
        file_put_contents($cache_file, $content);
        opcache_invalidate($cache_file);
    }

    public function cache_load($binTemplate, $id) {
        $cache_file = $this->cache_dir($binTemplate) . $this->cache_file($binTemplate['id'], $id);
        if (is_file($cache_file)) {
            include $cache_file;
        }
        return false;
    }

    public function cache_created($binTemplate, $id) {
        $cache_file = $this->cache_dir($binTemplate) . $this->cache_file($binTemplate['id'], $id);
        if (is_file($cache_file)) {
            return filemtime($cache_file);
        }
        return false;
    }
}
