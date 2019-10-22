<?php

namespace Reactor\ContentAdapter\Types;

class BaseType {

    public $data = null;
    public $validator = null;
    public $settings;
    public $errors = array();

    public function __construct($settings) {
        $this->settings = $settings;
    }

    public function validate() {
        if ($this->validator !== null) {
            $this->validator->validate($this);
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function setData($data, $from_context = null) {
        if ($from_context !== null) {
            $data = call_user_func(array($this, $from_context), $data);
        }
        $this->data = $data;
    }

    public function getData($to_context = null) {
        if ($to_context !== null) {
            return call_user_func(array($this, $to_context), $this->data);
        }
        return $this->data;
    }

    public function isErrors() {
        return !empty($this->errors);
    }

    public function getState() {
        return array(
            'data' => $this->data,
            'errors' => $this->errors,
        );
    }

    public function setState($data) {
        $this->data = $data['data'];
        $this->errors = $data['errors'];
    }

}
