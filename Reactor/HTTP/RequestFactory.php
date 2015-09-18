<?php

namespace Reactor\HTTP;

class RequestFactory {
    

    function create() {
    // $_GET,
    // $_POST,
    // array(),
    // $_COOKIE,
    // $_FILES,
    // $_SERVER
    }

    function build() {
        $request = new Request();
        $request->GET = new ParamenterBag();

    }

}
