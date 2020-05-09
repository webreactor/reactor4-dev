<?php

namespace Reactor\Forms;

class ValidationManager {

    public $definitions;
    public $validators;

    public function __construct($settings) {
        if (isset($settings['validators'])) {
            $this->definitions = $settings['validators'];
        }
        $this->validators = array();
    }

    public function validate($field) {
        foreach ($this->validators as $key => $validator) {
            $rez = call_user_func($validator, $field);
            if ($rez !== true) {
                if (is_string($rez)) {
                    $message = $rez;
                } elseif (isset($this->definitions[$key][1])) {
                    $message = $this->definitions[$key][1];
                } else {
                    $message = '!error from '.implode('-', (array)$this->definitions[$key][0]);
                }
                $field->errors[] = $message;
            }
        }
    }

}
