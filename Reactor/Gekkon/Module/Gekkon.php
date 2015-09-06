<?php

namespace Reactor\Gekkon\Module;

class Gekkon extends \Reactor\Gekkon\Gekkon {

    function __construct($tpl_path, $bin_path)
    {
        parent::__construct($tpl_path, $bin_path);
        $this->tplGroup = new TemplateGroup($this);
    }

}
