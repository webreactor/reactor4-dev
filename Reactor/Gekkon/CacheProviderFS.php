<?php

namespace Reactor\Gekkon;

use Reactor\Gekkon\Interfaces\CacheProviderInterface;

class CacheProviderFS implements CacheProviderInterface {
    protected $base_dir;

    public function __construct($base_dir) {
        $this->base_dir = $base_dir;
    }

    protected function cache_dir($bin_template) {
        return $this->base_dir . abs(crc32($bin_template['id'])) . '/cache/';
    }

    protected function cache_file($tpl_name, $id = '') {
        $name = md5($id . $tpl_name);
        return $name[0] . $name[1] . '/' . $name.'.php';
    }

    public function clear_cache($bin_template, $id = null) {
        if ($id !== null) {
            $cache_file = $this->cache_dir($bin_template) . $this->cache_file($id);
            if (is_file($cache_file)) {
                unlink($cache_file);
            }
        } else {
            Gekkon::clear_dir($this->cache_dir($bin_template));
        }
    }

    public function save($bin_template, $content, $id) {
        $cache_file = $this->cache_dir($bin_template) . $this->cache_file($bin_template['id'], $id);
        Gekkon::create_dir(dirname($cache_file));
        file_put_contents($cache_file, $content);
        opcache_invalidate($cache_file);
    }

    public function cache_load($bin_template, $id) {
        $cache_file = $this->cache_dir($bin_template) . $this->cache_file($bin_template['id'], $id);
        if (is_file($cache_file)) {
            include $cache_file;
        }
        return false;
    }

    public function cache_created($bin_template, $id) {
        $cache_file = $this->cache_dir($bin_template) . $this->cache_file($bin_template['id'], $id);
        if (is_file($cache_file)) {
            return filemtime($cache_file);
        }
        return false;
    }
}
