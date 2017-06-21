<?php

namespace Reactor\WebService;

use Reactor\Common\Tools\StringTools;
use Reactor\Common\ValueScope\ValueScopeArray;

class QueryParameters extends ValueScopeArray {

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
        return StringTools::sanitizeBin($value);
    }

    public function buildQueryString($override = array()) {
        return http_build_query(array_merge($this->getAll(), $override));
    }

}
