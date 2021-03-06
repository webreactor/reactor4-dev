<?php

namespace Reactor\Application;

use Symfony\Component\Yaml\Yaml;
use Reactor\Common\Tools\FileSystemTools;

class YMLConfig {

    function __construct($cache_dir) {
        $this->cache_dir = $cache_dir;
    }

    function lazyLoad($file) {
        return function() use ($file) {
            return $this->load($file);
        };
    }

    function load($file) {
        $cache_file = $this->cacheFileName($file);
        if (!$this->goodCache($file, $cache_file)) {
            if ($this->compileFile($file, $cache_file) === false) {
                throw new Exception("Failed to write config cache ".$cache_file, 1);
            }
        }
        require $cache_file;
        return $data;
    }

    function compileFile($file, $compiled_file) {
        $content = file_get_contents($file);
        $code = $this->compileYML($content);
        if ($code !== false) {
            $code = "<?php\n\$data = ".$code.";\n";
            FileSystemTools::createDir($this->cache_dir);
            return file_put_contents($compiled_file, $code);
        }
        return false;
    }

    function compileYML($data) {
        $data = Yaml::parse($data);
        return $this->compileData($data);
    }

    function compileData($data) {
        $code = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->compileData($value);
            } else {
                $value = $this->compileScalar($value);
            }
            $code .= var_export($key, true). ' => '.$value.",\n";
        }
        return 'array('.$code.')';
    }

    function compileScalar($value) {
        if (is_string($value) && strlen($value) > 1) {
            if (substr($value, 0, 2) == '/<') {
                return var_export(substr($value, 1), true);
            }
            if ($value[0] == '<') {
                return $this->compileMetaVar(substr($value, 1));
            }
        }
        return var_export($value, true);
    }

    function goodCache($file, $cache) {
        if (!is_file($cache)) {
            return false;
        }
        return filemtime($file) <= filemtime($cache);
    }

    function compileMetaVar($value) {
        if ($value[0] == '?') {
            return substr($value, 1);
        }
        return var_export($value, true);
    }

    function cacheFileName($file) {
        return $this->cache_dir.md5($file).'.php';
    }

}

