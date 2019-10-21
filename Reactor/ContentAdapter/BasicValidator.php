<?php

namespace Reactor\ContentAdapter;

class BasicValidator {

    static function notNull($field) {
        return $field->data !== null;
    }

    static function notEmpty($field) {
        return !empty($field->data);
    }

}
