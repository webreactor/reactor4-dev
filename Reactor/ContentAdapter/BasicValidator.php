<?php

namespace Reactor\ContentAdapter;

class BasicValidator {

    public function notNull($field) {
        return $field->data !== null;
    }

}
