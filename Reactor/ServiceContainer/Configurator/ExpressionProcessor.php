<?php

namespace Reactor\ServiceContainer\Configurator;

class ExpressionProcessor extends BaseValueProcessor {

    public function init() {
        $this->compiler = new Expression\ExpressionCompileManager();
        $this->compiler->registerCompiler(
            new Expression\ClassWrapperExpression(
                $this->configurator->container,
                '@', 'Reactor\\ServiceContainer\\Reference')
        );
        $this->compiler->registerCompiler(
            new Expression\ClassWrapperExpression(
                $this->configurator->container,
                '!', 'Reactor\\ServiceContainer\\ConstantReference')
        );
        $this->compiler->registerCompiler(
            new Expression\ClassWrapperExpression(
                $this->configurator->container,
                '$', 'Reactor\\ServiceContainer\\EnvironmentReference')
        );
        $this->compiler->registerCompiler(new Expression\TemplateExpression($this->compiler));
    }

    public function handleValue($value) {
        return $this->compiler->compile($value);
    }
}
