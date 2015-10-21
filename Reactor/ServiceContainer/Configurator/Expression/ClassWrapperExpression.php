<?php

namespace Reactor\ServiceContainer\Configurator\Expression;

class ClassWrapperExpression extends PrefixedExpression {

    protected $class;

    public function __construct($token, $class) {
        $this->token = $token;
        $this->class = $class;
    }

    public function compileLogic($value) {
        $class = $this->class;
        return new $class($value);
    }

}
