<?php

namespace Reactor\Gekkon;

use Reactor\Gekkon\Interfaces\BinTemplateProviderInterface;

class BinTplProviderFS implements BinTemplateProviderInterface {
    public $base_dir;
    protected $loaded = array();

    public function __construct($gekkon, $base) {
        $this->base_dir = rtrim($base, '/').'/';
        $this->gekkon = $gekkon;
    }

    protected function full_path($template) {
        $bin_path = $this->base_dir . abs(crc32($template->get_id())) . '/';
        return $bin_path . $template->get_short_name() . '.php';
    }

    public function load($template) {
        $template_id = $template->get_id();
        if (isset($this->loaded[$template_id])) {
            return $this->loaded[$template_id];
        }
        $file = $this->full_path($template);
        if (is_file($file)) {
            $value = include($file);
            $bin = new BinTemplate($this->gekkon, $value);
            $this->loaded[$template_id] = $bin;
            return $bin;
        }
        return false;
    }

    public function save($template, $bin_tpl_code) {
        Gekkon::create_dir(dirname($file = $this->full_path($template)));
        unset($this->loaded[$template->get_id()]);
        file_put_contents($file, '<?php return ' . $bin_tpl_code->code() . ';');
        opcache_invalidate($file);
    }

    public function clear_cache($template) {
        if (is_file($file = $this->full_path($template)) !== false) {
            unlink($file);
        }
    }
}
