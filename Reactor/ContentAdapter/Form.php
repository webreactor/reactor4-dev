<?php

namespace Reactor\ContentAdapter;

use \Reactor\ValueScope\ValueScopeArray;

class Form {

    public $fields = array();
    public $settings = array();
    public $errors = array();
    public $validator = null;

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

    public function setData($data, $context = null) {
        $data = new ValueScopeArray($data);
        foreach ($this->fields as $key => $field) {
            $field->setData($data->get($key, null), $context);
        }
    }

    public function getData($context = null) {
        $data = array();
        foreach ($this->fields as $key => $field) {
            $data[$key] = $field->getData($context);
        }
        return $data;
    }

    public function isErrors() {
        foreach ($this->fields as $key => $field) {
            if ($field->isErrors()) {
                return true;
            }
        }
        return false;
    }

    public function getState() {
        $data = array();
        foreach ($this->fields as $key => $field) {
            $data[$key] = $field->getState();
        }
        return array(
            'fields' => $data,
            'settings' => $this->settings,
            'errors' => $this->errors,
        );
    }

    public function setState($data) {
        foreach ($data['fields'] as $key => $field_data) {
            $this->fields[$key]->setState($field_data);
        }
        $this->settings = $data['settings'];
        $this->errors = $data['errors'];
    }

}
