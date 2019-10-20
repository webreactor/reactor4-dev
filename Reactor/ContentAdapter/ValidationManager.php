<?php

namespace Reactor\ContentAdapter;

class ValidationManager {

    public $definitions;
    public $validators;

    public function __construct($settings) {
        $this->definitions = $settings;
    }

    public function validate($field) {
        foreach ($this->validators as $key => $validator) {
            if (!call_user_func($validator, $field)) {
                if (isset($this->definitions[$key][2])) {
                    $message = $this->definitions[$key][2];
                } else {
                    $message = '!error from '.implode(' ', $this->definitions[$key]);
                }
                $field->errors[] = $message;
            }
        }
    }

}
