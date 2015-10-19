<?php

namespace Reactor\ServiceContainer\Configurator\Expression;

class PrefixedExpression implements ExpressionCompilerInterface {

    protected $token;

    public function compile($value) {
        if ($value == '' || $value[0] != $this->token) {
            return $value;
        }
        $value = substr($value, 1);
        if ($value != '' && $value[0] == $this->token) {
            return $value;
        }
        return $this->compileLogic($value);
    }

    public function compileLogic($value) {
        return $value;
    }

}
