<?php

namespace Reactor\Gekkon;

class BinTplProviderFS {

    private $base_dir;
    private $loaded = array();

    function __construct($gekkon, $base)
    {
        $this->base_dir = $base;
        $this->gekkon = $gekkon;
    }

    private function full_path($association)
    {
        $bin_name = basename($association);
        $bin_path = $this->base_dir.abs(crc32($association)).'/';
        return $bin_path.$bin_name.'.php';
    }

    function load($template)
    {
        if(isset($this->loaded[$template->name]))
                return new binTemplate($this->gekkon,
                    $this->loaded[$template->name]);

        $file = $this->full_path($template->association);
        if(is_file($file))
        {
            $bins = include($file);
            $this->loaded = array_merge($this->loaded, $bins);
            return new binTemplate($this->gekkon, $this->loaded[$template->name]);
        }
        return false;
    }

    function save($template, $binTplCodeSet)
    {
        Gekkon::create_dir(dirname($file = $this->full_path($template->association)));
        unset($this->loaded[$template->name]);
        file_put_contents($file, '<?php return '.$binTplCodeSet->code());
    }

    function clear_cache($template)
    {
        if(is_file($file = $this->full_path($template->association)) !== false)
                unlink($file);
    }

}