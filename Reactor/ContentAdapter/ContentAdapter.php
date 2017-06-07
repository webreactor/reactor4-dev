<?php

namespace Reactor\ContentAdapter;

class ContentAdapter extends ContentTypeInterface {

    protected $definition = array();

    public function __construct($definition = array()) {
        $this->definition = $definition;
    }

    public function addFiend($name, $type_handler) {
        $this->definition[$name] = $type_handler;
    }

    public function run($method, $data) {
        $all_return = array();
        foreach ($this->definition as $name => $handler) {
            $value =  isset($data[$name]) ? $data[$name] : null;
            $ret = call_user_func(array($handler, $method), $value);
            $all_return[$name] = $ret;
        }
        return $all_return;
    }

    public function fromDB($data) {
        
    }

    public function toDB($data) {
        
    }

    public function fromForm($data) {
        
    }

    public function toForm($data) {
        
    }

}
