<?php

namespace Reactor\WebService;

class StandardRouterContext {

    public $words;
    public $current_word = 0;
    public $node = null;
    public $path = array();

    public function __construct($words) {
        $this->words = $words;
    }

    public function registerNode($node) {
        $this->path[] = $node;
        $this->node = $node;
    }

}
