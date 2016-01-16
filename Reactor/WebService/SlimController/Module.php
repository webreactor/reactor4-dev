<?php

namespace Reactor\WebRouter;

class Module extends \Reactor\Application\Module {

    public function configure($container, $config = array()) {
        $configurator = parent::configure($container, $config);
        $compiler = new SlimControllerCompiler($this->exp_compiler);
        $compiler->compile_tree($this->site_tree);
    }

}
