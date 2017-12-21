<?php

namespace Reactor\WebService\SlimControllerGenerator;

class ControllerSourceGenerator {

    public $methods;
    public $class_name;
    public $settings = array();

    public function __construct($class_name, $definition, $module_full_name) {
        if (isset($definition['_settings'])) {
            $this->settings = $definition['_settings'];
            unset($definition['_settings']);
        }
        $this->methods = $definition;
        $this->class_name = $class_name;
        $this->module_full_name = $module_full_name;
    }

    public function getSource() {
        $settings = $this->settings;
        $src = "class ".$this->class_name." ";
        if (!empty($settings['extends'])) {
            if (is_object($settings['extends'])) {
                $settings['extends'] = class_name($settings['extends']);
            }
            $src .= "extends ".implode(', ',(array)$settings['extends']).' ';
        }

        if (!isset($settings['implements'])) {
            $settings['implements'] = array('\\Reactor\\UserAccessControl\\OpenAccessControl');
        }

        if (!empty($settings['implements'])) {
            $src .= "implements ".implode(', ',(array)$settings['implements']).' ';
        }
        $src .= "{\n";
        $src .= "\nprotected \$container;\n";
        $src .= "\npublic function __construct(\$container, \$uac) { \$this->container = \$container; }\n";
        $src .= "\n".$this->methods();
        $src .= "}\n\n";
        return $src;
    }


    public function methods() {
        $src = '';
        $module_full_name = $this->module_full_name;
        foreach ($this->methods as $key => $arguments) {
            $m = "public function $key(\$request_response) {\n";
            $m .= "\t\$request = \$request_response->request;\n";
            $m .= "\t\$get = \$request->get;\n";
            $m .= "\t\$post = \$request->post;\n";
            $m .= "\t\$container = \$this->container;\n";
            $m .= "\treturn \$this->uac->getExecuter(\$request->metadata['user'], '{$module_full_name}')->execute('/{$arguments['service']}', '{$arguments['method']}', array(".implode(',', $arguments['arguments'])."));\n";
            $m .= "}\n";
            $src .= $m."\n";
        }
        return $src;
    }
}
