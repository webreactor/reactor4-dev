<?php

namespace Reactor\Application;

class ApplicationCacher {

    public function __construct($callable, $cache_path, $force_new) {

    }

    public function store($cache_path, $application) {
        $dump = "<?php\n \\\\ Generated ".date("r")."\n return";
        $dump .= var_export($application, true);
        $dump .= ";\n";
        file_put_contents($cache_path, $dump);
    }

    public function load() {
        $application = include $cache_path;
        return $application;
    }

    public function isset($file) {
        return is_file($file);
    }

    public function get() {

    }

}
