<?php

namespace Reactor\WebService;

class RenderTask {

    public $path = array();
    public $task = null;

    public function registerStep($step) {
        $this->path[] = $step;
        $this->task = $step;
    }

}
