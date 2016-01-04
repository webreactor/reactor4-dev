<?php

namespace Reactor\WebService;

use Reactor\Common\ValueScope\ValueScope;

class Request {

    public $post;
    public $query;
    public $content;
    public $files;
    public $cookies;
    public $parameters;

    public $data;
    public $metadata;

    public function __construct(
        $get = array(),
        $post = array(),
        $content = null,
        $files = array(),
        $cookies = array(),
        $parameters = array() // expects request related keys from $_SERVER
    ) {
        $this->query = new QueryParameters($get);
        $this->post = $post;
        $this->content = $content;
        $this->files = $files;
        $this->cookies = $cookies;
        $this->parameters = new RequestParameters($parameters);
        $this->metadata = new ValueScope();
    }

    public function uri() {
        return $this->parameters->get('REQUEST_URI');
    }

    public function method() {
        return $this->parameters->get('REQUEST_METHOD');
    }

    public function queryString() {
        return $this->parameters->get('QUERY_STRING');
    }

    public function scheme() {
        return $this->parameters->get('REQUEST_SCHEME');
    }

    public function headers() {
        return $this->parameters->headers();
    }

    public function body() {
        if ($this->content === null) {
            $this->content = file_get_contents("php://input");
            if (!$this->content) {
                $this->content = '';
            }
        }
        return $this->content;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

}
