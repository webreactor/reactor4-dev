<?php

namespace Reactor\WebService;

class Response {
    public $code;
    public $headers;
    public $body;

    public function __construct($body = '', $code = 200, $headers = array()) {
        $this->headers = $headers;
        $thid->body = $body;
        $thid->code = $code;
    }

}
