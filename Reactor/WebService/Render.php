<?php

namespace Reactor\WebService;

class Render {

    public function __construct($application) {
        $this->application = $application;
    }

    public function render($request_response) {
        echo "<h1>Render</h1><pre>\n";
        print_r($request_response);
    }
    
}
