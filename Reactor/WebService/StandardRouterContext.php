<?php

namespace Reactor\WebService;

class StandardRouterContext {

    public $words;
    public $current_word = 0;
    public $node = null;
    public $steps = array();

    public function __construct($words) {
        $this->words = $words;
    }

}
