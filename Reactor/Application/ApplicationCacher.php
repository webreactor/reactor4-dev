<?php

namespace Reactor\Application;

class ApplicationCacher {

    protected $cache_path;

    public function __construct($cache_path) {
        $this->cache_path = $cache_path;
    }

    public function create($callable) {
        return call_user_func_array($callable, array());
    }

    public function store($cache_file, $application) {
        $dir = dirname($cache_file).'/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $application->__sleep();
        $dump = "<?php\n// Generated ".date("r")."\nreturn ";
        $dump .= var_export($application, true);
        $dump .= ";\n";
        $tmp_file = $cache_file.'.tmp';
        file_put_contents($tmp_file, $dump);
        if ($this->checkPHPSyntax($tmp_file, $details)) {
            rename($tmp_file, $cache_file);
        } else {
            throw new Exception("Error creating application cache. ".print_r($details, true));
        }
    }

    public function checkPHPSyntax($file, &$details) {
        exec('php -l '.$file, $details, $return_var);
        return $return_var == 0;
    }

    public function load($cache_path) {
        $application = include $cache_path;
        return $application;
    }

    public function get($callable, $cache_name, $use_cache = true) {
        if (!$use_cache) {
            return $this->create($callable);
        }
        $cache_file = $this->getCacheFile($cache_name);
        if (is_file($cache_file)) {
            return $this->load($cache_file);
        }
        $application = $this->create($callable);
        $this->store($cache_file, $application);
        return $application;
    }

    public function remove($cache_name) {
        $cache_file = $this->getCacheFile($cache_name);
        if (is_file($cache_file)) {
            remove($cache_file);
        }
    }

    public function getCacheFile($cache_name) {
        return $this->cache_path.$cache_name.'.php';
    }

}
