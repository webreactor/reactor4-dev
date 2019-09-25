<?php

namespace Reactor\WebService;

class RouterContext {

    public
        $cursor = 0,
        $path = array(),
        $variables,

        $target = array(),
        $steps = array(),
        $error_handlers = array(),
        $is_error = false,
        $new_target = true;

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

    public function switchToError() {
        $this->target = array_pop($this->error_handlers);
        $this->is_error = true;
        $this->new_target = true;
        return !empty($this->target);
    }

    public function getTarget($key, $default = null) {
        if (isset($this->target[$key])) {
            $value = (array)$this->target[$key];
            if ($default !== null) {
                $value += $default;
            }
        } else {
            $value = $default;
        }
        return $value;
    }
}
