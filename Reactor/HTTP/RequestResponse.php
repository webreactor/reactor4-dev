<?php

namespace Reactor\HTTP;

class RequestResponse {

    public $request;
    public $response

    public function __construct($request, $response) {
        $this->request = $request;
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
