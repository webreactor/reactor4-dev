<?php

namespace Reactor\Gekkon;

class TemplateProviderFS {
    protected $base_dir;

    function __construct($base_dir) {
        $this->base_dir = $base_dir;
    }

    function load($short_name) {
        $file = $this->get_full_name($short_name);
        return new TemplateFS($file);
    }

    function set_module($base_dir) {
        $this->base_dir = $base_dir;
    }

    function get_full_name($name) {
        return $this->base_dir . $name;
    }

    /**
     * @param TemplateFS $template
     * @return array
     */
    function get_associated($template) {
        $association = $template->association();
        $rez = array();
        $dir = dirname($template->name) . '/';
        foreach (scandir($dir) as $file) {
            if ($file[0] != '.') {
                $test = new TemplateFS($dir . $file);
                if (strrchr($file, '.') === '.tpl' && $association === $test->association()) {
                    $rez[] = $test;
                }
            }
        }
        return $rez;
    }
}
