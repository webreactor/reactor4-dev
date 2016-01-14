<?php

namespace Reactor\WebService;

class RequestResponse {

    public $request;
    public $original;
    public $response;

    public function __construct($request, $response = null) {
        $this->request = $request;
        $this->original = clone $request;
        if ($response === null) {
            $response = new Response();
        }
        $this->response = $response;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getResponse() {
        return $this->response;
    }

    public function setRequest($request) {
        $this->request = $request;
    }

    public function setResponse($response) {
        $this->response = $response;
    }

}
