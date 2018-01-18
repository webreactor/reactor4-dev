<?php

namespace Reactor\WebApp;

class RouterContext {

    public
        $cursor = 0,
        $node = null,
        $nodes = null,
        $path = array(),
        $not_found = false,
        $not_found_node = null;

    function __construct($path) {
        $this->path = $path;
    }

    function apply404() {
        $this->node = $this->not_found_node;
        $this->not_found = true;
        return $this;
    }
}