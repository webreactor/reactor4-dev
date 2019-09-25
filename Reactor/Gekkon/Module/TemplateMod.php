<?php

namespace Reactor\Gekkon\Module;

use Reactor\Gekkon\TemplateFS;

class TemplateMod extends TemplateFS {

    protected $id;

    public function __construct($module, $short_name, $file) {
        parent::__construct($module, $short_name, $file);
        $this->id = $this->module->getFullName().'//'.$this->short_name;
    }

    public function get_id() {
        return $this->id;
    }

}
