<?php

namespace Reactor\ServiceContainer\Configurator\Expression;

class ExpressionCompileManager implements ExpressionCompilerInterface {

    public $compilers = array();

    public function compile($value) {
        if (!is_string($value) || $value === '') {
            return $value;
        }
        foreach($this->compilers as $compiler) {
            $rez = $compiler->compile($value);
            if ($rez !== $value) {
                return $rez;
            }
        }
        return $value;
    }

    public function registerCompiler(ExpressionCompilerInterface $compiler) {
        $this->compilers[] = $compiler;
        return $this;
    }

}
