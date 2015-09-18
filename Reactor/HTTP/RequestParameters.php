<?php

namespace Reactor\HTTP;

class RequestParameters {

    protected $data; // expects request related keys from $_SERVER

    public function __construct($data = array()) {
        $this->data = $data;
    }

    public function has($name, $value) {
        return isset($this->data[$name]);
    }    

    public function set($name, $value) {
        $this->data[$name] = $value;
    }

    public function get($name, $default = null) {
        if (isset($this->data[$name])) {
            return $this->data[$name];    
        }
        return $default;
    }

    public function headers() {
        if ($this->headers === null) {
            $this->headers = $this->parseHeaders($this->data);
        }
        return $this->headers;
    }

    public function parseHeaders($data) {
        $headers = array();
        $custom_headers = array(
            'CONTENT_LENGTH' => true,
            'CONTENT_TYPE' => true
        );
        foreach ($data as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[substr($key, 5)] = $value;
            } elseif (isset($custom_headers[$key])) {
                $headers[$key] = $value;
            }
        }
        return $headers;
    }

}
