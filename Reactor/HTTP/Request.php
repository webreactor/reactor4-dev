<?php

namespace Reactor\HTTP;

class Request {

    public $post;
    public $query;
    public $content;
    public $files;
    public $cookies;
    public $parameters;

    public $attributes;

    public function __construct(
        $get = array(),
        $post = array(),
        $content = null,
        $files = array()
        $cookies = array(),
        $parameters = array(), // expects request related keys from $_SERVER
    ) {
        $this->query = new QueryParameters($query);
        $this->post = $post;
        $this->content = $content;
        $this->files = $files;
        $this->cookies = $cookies;
        $this->parameters = new RequestParameters($parameters);
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

}
