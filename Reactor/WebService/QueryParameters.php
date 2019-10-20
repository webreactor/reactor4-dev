<?php

namespace Reactor\WebService;

use Reactor\Tools\StringTools;

class QueryParameters extends \ArrayObject {

    public function get($name, $default = null) {
        if (!isset($this['name'])) {
            return $default;
        }
        return $this['name'];
    }

    public function getInteger($name, $default = null) {
        $value = $this->get($name, $default);
        if ("$value" === ''.intval($value)) {
           return 0 + $value;
        }
        return $default;
    }

    public function getNumber($name, $default = null) {
        $value = $this->get($name, $default);
        if (is_numeric($value)) {
            return 0 + $value;
        }
        return $default;
    }

    public function getString($name, $default = null) {
        $value = $this->get($name, $default);
        if ($value !== null) {
            return StringTools::sanitizeBin($value);
        }
        return $default;
    }

    public function buildQueryString($override = array()) {
        return http_build_query(array_merge($this->getAll(), $override));
    }

}
