<?php

namespace Reactor\WebService;

class RequestResponse {

    public $request;
    public $response;

    public function __construct($request, $response = null) {
        $this->request = $request;
        if ($response === null) {
            $response = new Response();
        }
        $this->response = $response;
    }

}
