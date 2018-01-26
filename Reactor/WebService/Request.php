<?php

namespace Reactor\WebService;

use Reactor\Common\ValueScope\ValueScope;

class Request {

    public $link;
    public $link_original;

    public $method;

    public $headers;

    public $cookies;
    public $get;
    public $post;
    public $files;

    protected $body;
    public $metadata = array();
    public $route = null;

    public function __construct() {
        $this->link = new WebLink();
        $this->get = new QueryParameters();
        $this->post = new QueryParameters();
        $this->headers = new QueryParameters();
        $this->files = new QueryParameters();
        $this->cookies = new QueryParameters();
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function body() {
        if ($this->body === null) {
            $this->body = file_get_contents("php://input");
            if (!$this->body) {
                $this->body = '';
            }
        }
        return $this->body;
    }

    public function setLink($link) {
        $this->link = $link;
        $this->link_original = clone $link;
    }

    public function setGet($get) {
        $this->get = new QueryParameters($get);
    }

    public function setPost($post) {
        $this->post = new QueryParameters($post);
    }

    public function setCookies($cookies) {
        $this->cookies = new QueryParameters($cookies);
    }

    public function setFiles($files) {
        $this->files = new QueryParameters($files);
    }

    public function setHeaders($headers) {
        $this->headers = new QueryParameters($headers);
    }

}
