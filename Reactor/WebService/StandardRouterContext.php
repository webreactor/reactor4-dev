<?php

namespace Reactor\WebService;

class StandardRouterContext {

    public $words;
    public $current_word = 0;
    public $node = null;
    public $steps = array();

    public function construct($words) {
        $this->words = $words;
        $this->current_word = 0;
        $this->node = null;
    }

}
