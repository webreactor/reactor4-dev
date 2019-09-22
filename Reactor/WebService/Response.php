<?php

namespace Reactor\WebService;

class Response {
    public $code;
    public $headers;
    public $body;

    public function __construct($body = null, $code = 200, $headers = array()) {
        $this->headers = $headers;
        $this->body = $body;
        $this->code = $code;
    }

}
