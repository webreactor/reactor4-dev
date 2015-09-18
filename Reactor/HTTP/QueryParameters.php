<?php

namespace Reactor\HTTP;

class QueryParameters {

    protected $data;
    protected $override;

    public function __construct($data = array(), $override = array()) {
        $this->data = $data;
        $this->override = $override;
    }

    public function set($name, $value) {
        $this->override[$name] = $value;
    }

    public function has($name) {
        return $this->get($name) !== null;
    }

    public function get($name, $default = null) {
        if (isset($this->override[$name])) {
            return $this->override[$name];
        }
        if (isset($this->data[$name])) {
            return trim($this->data[$name]);
        }
        return $default;
    }

    public function getInteger($name, $default = null) {
        $value = $this->get($name, $default);
        if ("$value" == ''.intval($value)) {
           return 0 + $value;
        }
        return $default;
    }

    public function getNumber($name, $default = null) {
        $value = $this->get($name, $default);
        if (is_numeric($value)) {
            return 0 + $value;
        }
        return $default;
    }

    public function getAll() {
        return array_merge($this->data, $this->override);
    }

    public function getOrigin() {
        return $this->data;
    }

    public function getOrigin() {
        return $this->data;
    }

    public function buildQueryString($override = array()) {
        return http_build_query(array_merge($this->getAll(), $override));
    }

    public function buildOriginQueryString($override = array()) {
        return http_build_query(array_merge($this->data, $override));
    }

}
