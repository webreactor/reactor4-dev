<?php

namespace Reactor\Gekkon\Compiler;

class BinTemplateCodeSet extends \ArrayObject {

    function code()
    {
        $rez = "array(\n";
        foreach($this as $name => $tplCode)
        {
            $rez .= "'$name'=>".$tplCode->code().',';
        }
        $rez .= ");\n";
        return $rez;
    }

}

