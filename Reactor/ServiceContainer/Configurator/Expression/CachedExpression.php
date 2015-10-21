<?php

namespace Reactor\ServiceContainer\Configurator\Expression;

class CachedExpression extends PrefixedExpression {

    protected $compiler;
    protected $container;

    public function __construct($token, $container, $compiler) {
        $this->token = $token;
        $this->container = $container;
        $this->compiler = $compiler;
    }

    public function compileLogic($value) {
        return $this->container->resolveProviders($this->compiler->compile($value));
    }

}
