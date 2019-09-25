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

}
