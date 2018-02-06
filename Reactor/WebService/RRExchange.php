<?php

namespace Reactor\WebService;

class RequestResponse {

    public
        $request,
        $response,
        $route;

    public function __construct($request = null, $response = null, $route = null) {
        $this->request = $request;
        $this->response = $response;
        $this->route = $route;
    }

}
