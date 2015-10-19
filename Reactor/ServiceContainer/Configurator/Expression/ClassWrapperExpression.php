<?php

namespace Reactor\ServiceContainer\Configurator\Expression;

class ClassWrapperExpression extends PrefixedExpression {

    protected $class;

    public function __construct($container, $token, $class) {
        $this->container = $container;
        $this->token = $token;
        $this->class = $class;
    }

    public function compileLogic($value) {
        $class = $this->class;
        if ($value != '' && $value[0] == '*') {
            $value = substr($value, 1);
            return (new $class($value))->getService($this->container);
        }
        return new $class($value);
    }

}
