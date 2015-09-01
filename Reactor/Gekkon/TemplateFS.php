<?php

namespace Reactor\Gekkon;

class TemplateFS {

    var $name;
    var $association;

    function __construct($name, $association)
    {
        $this->name = $name;
        $this->association = $association;
    }

    function check_bin($binTemplate)
    {
        return filemtime($this->name) < $binTemplate['created'];
    }

    function source()
    {
        return file_get_contents($this->name);
    }

}