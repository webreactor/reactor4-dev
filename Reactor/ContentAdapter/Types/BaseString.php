<?php

namespace Reactor\ContentAdapter\Types;

class BaseString extends BaseType {

    public function toForm($data) {
        return $data;
    }

    public function fromForm($data) {
        if (!is_string($data)) {
            return null;
        }
        return htmlspecialchars($data, ENT_QUOTES);
    }

    public function toDb($data) {
        return $data;
    }

    public function fromDb($data) {
        return $data;
    }

}
