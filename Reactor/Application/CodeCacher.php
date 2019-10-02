<?php

namespace Reactor\Application;

class CodeCacher extends MultiService {

    public $loaded = array();
    public $cache_dir;


    public function __construct($cache_dir) {
        $this->cache_dir = $cache_dir;
    }

    public function saveData($id, $data) {
        return $this->saveCode($id, var_export($data, true));
    }

    public function saveCode($id, $code) {
        $cache_file = $this->cacheFileName($id);
        return $this->writeCache($cache_file, $code);
    }

    public function load($id) {
        $cache = $this->loadRaw($id);
        if ($cache !== false) {
            return $cache['data'];
        }
        return false;
    }

    protected function loadRaw($id) {
        $cache_file = $this->cacheFileName($id);
        if (!isset($this->loaded[$cache_file])) {
            if (!is_file($cache_file)) {
                return false;
            }
            include $cache_file;
            $this->loaded[$cache_file] = $cache;
        }
        return $this->loaded[$cache_file];
    }

    public function created($id) {
        $cache = $this->loadRaw($id);
        if ($cache !== false) {
            return $cache['created'];
        }
        return 0;
    }

    public function writeCache($file, $raw_code) {
        $code = "<?php\n" .
            '$cache = array("created" => ' . time() . ",\n" .
            '"data" => ' . $raw_code . ",\n" .
            ');';
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $temp_file = $dir.'/'.microtime(true).'.php';
        file_put_contents($temp_file, $code);
        if ($this->checkPHPSyntax($temp_file)) {
            rename($temp_file, $file);
            opcache_invalidate($file);
            unset($this->loaded[$file]);
            return true;
        }
        unset($temp_file);
        return false;
    }

    public function clear($id) {
        $cache_file = $this->cacheFileName($id);
        if (is_file($cache_file)) {
            unlink($cache_file);
        }
    }

    public function checkPHPSyntax($file) {
        exec('php -l '.$file, $details, $return_var);
        return $return_var == 0;
    }

    public function cacheFileName($id) {
        return $this->cache_dir.md5($id).'.php';
    }

}
