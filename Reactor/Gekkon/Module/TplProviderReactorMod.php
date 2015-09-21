<?php

namespace Reactor\Gekkon\Module;

use Reactor\Gekkon\TemplateProviderFS;

class TplProviderReactorMod extends TemplateProviderFS {

    public function __construct($module) {
        $this->module = $module;
    }

    protected function get_file($short_name) {
        return $this->module->getDir() . 'tpl/' . $short_name;
    }

    public function load($short_name) {
        return new TemplateMod($this->module, $short_name, $this->get_file($short_name));
    }

    public function get_associated($template) {
        $association = $this->association_id($template);
        $rez = array();
        $short_name = $template->get_short_name();
        $dir = $this->dirname($this->get_file($short_name));
        $short_prefix = $this->dirname($short_name);
        foreach (scandir($dir) as $file) {
            if ($file[0] != '.' && strrchr($file, '.') === '.tpl') {
                $test = new TemplateMod($template->get_module(), $short_prefix . $file, $dir.'/'.$file);
                if ($association === $this->association_id($test)) {
                    $rez[] = $test;
                }
            }
        }
        return $rez;
    }

}
