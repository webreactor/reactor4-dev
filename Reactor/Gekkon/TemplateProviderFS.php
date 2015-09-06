<?php

namespace Reactor\Gekkon;

class TemplateProviderFS {

    protected $base_dir;

    function __construct($base_dir)
    {
        $this->base_dir = $base_dir;
    }

    function load($short_name)
    {
        $file = $this->get_full_name($short_name);
        if(is_file($file))
                return new TemplateFS($file, $this->get_association_name($file));
        return false;
    }

    function set_module($base_dir) {
        $this->base_dir = $base_dir;
    }

    function get_full_name($name)
    {
        return $this->base_dir.$name;
    }

    protected function get_association_name($name)
    {
        $name = basename($name);
        if(($t = strpos($name, '_')) !== false) return substr($name, 0, $t);
        return $name;
    }

    function get_associated($template)
    {
        $rez = array();
        $dir = dirname($template->name).'/';
        foreach(scandir($dir) as $file)
        {
            if($file[0] != '.')
            {
                if(strrchr($file, '.') === '.tpl' && $template->association === $this->get_association_name($dir.$file))
                        $rez[] = new TemplateFS($dir.$file,
                            $this->get_association_name($dir.$file));
            }
        }
        return $rez;
    }

}
