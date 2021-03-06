<?php

namespace Reactor\Gekkon\Tags\Common;
use \Reactor\Gekkon\Compiler\BaseTag;

class Tag_use extends BaseTag {
    function compile($compiler) {
        $exp = $compiler->exp_compiler->compile_exp($this->args_raw);
        if ($exp === false) {
            return $compiler->error_in_tag('Cannot compile expression "' . $this->args_raw . '"', $this);
        }
        $exp = $compiler->exp_compiler->join_scopes($exp);
        $saver = '$_gkn_use' . $compiler->getUID();
        return "$saver=\$scope;\n" . "\$scope=$exp;\n" . $compiler->compile_str($this->content_raw, $this) . "\$scope=$saver;\n";
    }
}

//end of class