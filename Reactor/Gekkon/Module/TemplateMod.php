<?php

namespace Reactor\Gekkon\Module;

use Reactor\Gekkon\TemplateFS;

class TemplateMod extends TemplateFS {

    public function get_id() {
        return $this->module->getFullName().'//'.$this->short_name;
    }

}
