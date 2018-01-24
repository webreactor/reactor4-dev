<?php

namespace Reactor\WebService\SlimControllerGenerator;

class Generator {
    protected $bin_dir;

    public function __construct($bin_dir) {
        $this->bin_dir = $bin_dir;
    }

    public function generate($class_name, $definition) {
        $full_class_name = 'ReactorGenerated\\SlimControllers\\'.$class_name;
        $file_name = $this->bin_dir.'SlimControllers/'.\str_replace('\\', '/', $class_name).'.php';

        $t = strrpos($full_class_name, '\\');
        $namespace = substr($full_class_name, 0, $t);
        $class_name = substr($full_class_name, $t + 1);
        $builder = new ControllerSourceGenerator($class_name, $definition);

        $bin_dir = dirname($file_name);
        if (!is_dir($bin_dir)) {
            mkdir($bin_dir, 0777, true);    
        }
        $src ="<?php\n";
        $src .="namespace $namespace;\n";
        $src .= $builder->getSource();
        file_put_contents($file_name, $src);
        return $full_class_name;
    }


}
