<?php

namespace Reactor\WebService;

class RequestResponse {

    public $request;
    public $response;
    public $route;

    public function __construct($request, $response = null, $route = null) {
        $this->request = $request;
        $this->response = $response;
        $this->route = $route;
    }

}
