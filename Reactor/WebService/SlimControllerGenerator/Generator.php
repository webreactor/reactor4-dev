<?php

namespace Reactor\WebService\SlimControllerGenerator;

class Generator {
    protected $application;

    public function __construct($application) {
        $this->application = $application;
    }

    public function generate($definition) {
        $builder = new ControllerSourceGenerator($definition);
        echo "Store source:".$builder->getSource();
        return $builder->class_name;
    }


}
