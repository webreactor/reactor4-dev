<?php

namespace Reactor\Gekkon\Module;

use Reactor\Gekkon\TemplateProviderFS;

class TplProviderReactorMod extends TemplateProviderFS {

    public function __construct($module) {
        $this->module = $module;
    }

    public function load($short_name) {
        $file = $this->module->getDir() . 'tpl/' . $short_name;
        return new TemplateMod($this->module, $short_name, $file);
    }

    public function get_associated($template) {
        $association = $this->association_id($template);
        $rez = array();
        $dir = $this->dirname($template->get_file());
        $short_name = $this->dirname($template->get_short_name());
        foreach (scandir($dir) as $file) {
            if ($file[0] != '.' && strrchr($file, '.') === '.tpl') {
                $test = new TemplateMod($template->get_module(), $short_name . $file, $dir.'/'.$file);
                if ($association === $this->association_id($test)) {
                    $rez[] = $test;
                }
            }
        }
        return $rez;
    }

}
