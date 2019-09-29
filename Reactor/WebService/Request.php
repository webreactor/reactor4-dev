<?php

namespace Reactor\WebService;

class Request {

    public $link;

    public $method;

    public $headers;

    public $cookies;
    public $get;
    public $post;
    public $files;

    protected $body;

    public function body() {
        if ($this->body === null) {
            $this->body = file_get_contents("php://input");
            if (!$this->body) {
                $this->body = '';
            }
        }
        return $this->body;
    }

}
