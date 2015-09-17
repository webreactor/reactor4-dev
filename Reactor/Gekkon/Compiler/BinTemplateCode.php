<?php

namespace Reactor\Gekkon\Compiler;

class BinTemplateCode {
    var $template;
    var $meta = array();
    var $blocks = array();

    function __construct($compiler, $template) {
        $this->template = $template;
        $this->blocks['__main'] = '';
        $this->blocks['__constructor'] = '';
        $this->meta['created'] = time();
        $this->meta['name'] = $this->template->name;
        $this->meta['association'] = $this->template->association();
        $this->meta['gekkon_ver'] = $compiler->gekkon->version;
    }

    function code() {
        $rez = "array(";
        foreach ($this->meta as $name => $value) {
            $rez .= "'$name'=>" . var_export($value, true) . ",\n";
        }
        $rez .= "'blocks'=> array(\n";
        foreach ($this->blocks as $name => $block) {
            $rez .= "'$name'=>function (\$template,\$gekkon,\$scope){\n" . $block . "},\n";
        }
        $info = array();
        $rez .= "))\n";
        return $rez;
    }
}
