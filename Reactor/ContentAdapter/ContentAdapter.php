<?php

namespace Reactor\ContentAdapter;

class ContentAdapter implements ContentTypeInterface {

    protected $definition = array();

    public function __construct($definition = array()) {
        $this->definition = $definition;
    }

    public function addField($name, $type_handler) {
        $this->definition[$name] = $type_handler;
    }

    public function run($method, $data) {
        $rezult = array();
        foreach ($this->definition as $name => $handler) {
            $value =  isset($data[$name]) ? $data[$name] : null;
            $rezult[$name] = call_user_func(array($handler, $method), $value);
        }
        return $rezult;
    }

    public function validate($data) {
        $errors = $this->run('validate', $data);
        $rezult = array();
        foreach ($errors as $key => $error) {
            if (!empty($error)) {
                $rezult[$key] = $error;
            }
        }
        return $rezult;
    }

    public function fromDB($data) {
        return $this->run('fromDB', $data);
    }

    public function toDB($data) {
        return $this->run('toDB', $data);
    }

    public function fromForm($data) {
        return $this->run('fromForm', $data);
    }

    public function toForm($data) {
        return $this->run('toForm', $data);
    }

}
