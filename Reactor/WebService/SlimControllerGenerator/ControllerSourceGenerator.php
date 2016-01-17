<?php

namespace Reactor\WebService\SlimControllerGenerator;

class ControllerSourceGenerator {

    public $definition;
    public $class_name;

    public function __construct($definition) {
        $this->definition = $definition;
        $this->class_name = uniqid();
    }

    public function getSource() {
        $src = "class ".$this->class_name." {\n";
        $src .= $this->methods();
        $src .= "}\n";

        return $src;
    }


    public function methods() {

    }
}
