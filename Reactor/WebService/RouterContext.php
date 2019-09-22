<?php

namespace Reactor\WebService;

class RouterContext {

    public
        $cursor = 0,
        $path = array(),
        $variables,

        $target = array(),
        $steps = array(),
        $not_found = false,
        $not_found_node = null;

    public function __construct($path) {
        $this->variables = new QueryParameters();
        $this->path = $this->normalizePath($path);
    }

    public function normalizePath($path) {
        $path = trim($path, '/');
        if ($path == '') {
            $path = array();
        } else {
            $path = explode('/', $path);
        }
        return $path;
    }

    public function getTarget($key, $val0 = null, $val1 = null) {
        $value = array($val0, $val1);
        if (isset($this->target[$key])) {
            $value = (array)$this->target[$key];
            if (!isset($value[1])) {
                $value[1] = $val1;
            }
        }
        return $value;
    }
}
