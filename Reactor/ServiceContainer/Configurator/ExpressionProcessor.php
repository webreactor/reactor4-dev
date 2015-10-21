<?php

namespace Reactor\ServiceContainer\Configurator;

class ExpressionProcessor extends BaseValueProcessor {

    public function init() {
        $this->compiler = new Expression\ExpressionCompileManager();
        $this->compiler->registerCompiler(
            new Expression\ClassWrapperExpression('@', 'Reactor\\ServiceContainer\\Reference')
        );
        $this->compiler->registerCompiler(
            new Expression\ClassWrapperExpression('!', 'Reactor\\ServiceContainer\\ConstantReference')
        );
        $this->compiler->registerCompiler(
            new Expression\ClassWrapperExpression('$', 'Reactor\\ServiceContainer\\EnvironmentReference')
        );
        $this->compiler->registerCompiler(new Expression\TemplateExpression($this->compiler));
        $this->compiler->registerCompiler(
            new Expression\CachedExpression(
                '*', $this->configurator->container,
                $this->compiler
            )
        );
    }

    public function handleValue($value) {
        return $this->compiler->compile($value);
    }
}
