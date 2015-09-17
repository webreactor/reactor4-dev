<?php

namespace Reactor\HTTP;

class Request {

    protected $uri;
    protected $method;
    protected $host;
    protected $post;
    protected $get;
    protected $body;
    protected $headers;
    protected $files;
    protected $cookies;

    public function __construct(
        $get = array(),
        $post = array(),
        $cookies = array(),
        $files = array(),
        $server = array(),
        $content = null
    ) {

        $this->get = $get;
        $this->post = $post;

    }

    public function set($name, $value) {
        $this->get[$name] = $value;
    }

    public function get($name, $default = null) {
        if (!isset($this->get[$name])) {
            return $default;
        }
        return trim($this->get[$name]);
    }

    public function getInteger($name, $default = null) {
        if (!isset($this->get[$name]) || "$name" !== "".intval($this->get[$name])) {
            return $default;
        }
        return intval($this->get[$name]);
    }

    public function getNumber($name, $default = null) {
        if (!isset($this->get[$name]) || !is_numeric($this->get[$name])) {
            return $default;
        }
        return 0 + $this->get[$name];
    }

    public function getAll() {
        return $this->get;
    }

}
