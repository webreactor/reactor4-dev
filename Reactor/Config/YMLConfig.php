<?php

namespace Reactor\Config;

use Symfony\Component\Yaml\Yaml;

class YMLConfig {

    public function __construct($base_dir, $code_cacher) {
        $this->base_dir = $base_dir;
        $this->code_cacher = $code_cacher;
    }

    public function lazyLoad($file) {
        return function() use ($file) {
            return $this->load($file);
        };
    }

    public function load($file) {
        if ($file[0] != '/') {
            $file = $this->base_dir . $file;
        }
        if (!$this->goodCache($file)) {
            if ($this->compileFile($file) === false) {
                throw new Exception("Failed to write config cache ".$cache_file, 1);
            }
        }
        return $this->code_cacher->load($file);
    }

    protected function goodCache($file) {
        $created = $this->code_cacher->created($file);
        return filemtime($file) < $created;
    }

    protected function compileFile($file) {
        $content = file_get_contents($file);
        $code = $this->compileYML($content);
        if ($code !== false) {
            return $this->code_cacher->saveCode($file, $code);
        }
        return false;
    }

    protected function compileYML($data) {
        $data = Yaml::parse($data);
        return $this->compileData($data);
    }

    protected function compileData($data) {
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

    protected function compileScalar($value) {
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

    protected function compileMetaVar($value) {
        if ($value[0] == '?') {
            return substr($value, 1);
        }
        if ($value[0] == '/') {
            return 'new \Reactor\ServiceContainer\Reference("'.substr($value, 1).'")';
        }
        return var_export($value, true);
    }

}
