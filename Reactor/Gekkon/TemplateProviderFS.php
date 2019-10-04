<?php

namespace Reactor\Gekkon;

use Reactor\Gekkon\Interfaces\TemplateProviderInterface;

class TemplateProviderFS implements TemplateProviderInterface{
    protected $base_dir;
    protected $module;

    public function __construct($base_dir) {
        $this->base_dir = rtrim($base_dir.'/').'/';
    }

    public function load($short_name) {
        return new TemplateFS($this->module, $short_name, $this->get_file($short_name));
    }

    public function set_module($module) {
        $this->module = $module;
    }

    protected function get_file($short_name) {
        return $this->base_dir . $this->module . $short_name;
    }

}
