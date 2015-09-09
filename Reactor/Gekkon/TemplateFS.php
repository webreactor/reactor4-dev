<?php

namespace Reactor\Gekkon;

class TemplateFS {

    var $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    function check_bin($binTemplate)
    {
        return filemtime($this->name) < $binTemplate['created'];
    }

    function source()
    {
        return file_get_contents($this->name);
    }
    
    function association()
    {
        $dir = dirname($this->name).'/';
        $name = basename($this->name);

        if(preg_match('/-|_|\./', $name, $matched, PREG_OFFSET_CAPTURE)) {
            $name = substr($name, 0, $matched[0][1]);
        }

        return $dir.$name.'.tpl';
    }
}