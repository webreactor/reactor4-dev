<?php

namespace Reactor\ContentAdapter;

use \Reactor\ValueScope\ValueScopeArray;

class Form {

    public $fields;

    public function __construct() {
        $this->fields = array();
    }

    public function validate() {
        foreach ($this->fields as $key => $field) {
            $field->validate();
        }
    }

    public function getErrors() {
        $errors = array();
        foreach ($this->fields as $key => $field) {
            $errors[$key] = $field->getErrors();
        }
        return $errors;
    }

    public function setData($data) {
        $data = new ValueScopeArray($data);
        foreach ($this->fields as $key => $field) {
            $field->setData($data->get($key, null));
        }
    }

    public function getData($context = null) {
        $data = array();
        foreach ($this->fields as $key => $field) {
            $data[$key] = $field->getData($context);
        }
        return $data;
    }

    public function getRenderData() {
        $data = array();
        foreach ($this->fields as $key => $field) {
            $data[$key] = $field->getRenderData();
        }
        return $data;
    }

}
