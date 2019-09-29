<?php

namespace Reactor\WebService;

class RouterContext {

    public
        $cursor = 0,
        $path = array(),
        $variables = array(),

        $target = array(),
        $steps = array(),
        $error_handlers = array(),
        $error = false,
        $new_target = true;

    public function __construct($path) {
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

    public function switchToError($error) {
        $this->target = array_pop($this->error_handlers);
        $this->error = $error;
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
