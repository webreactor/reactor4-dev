<?php

namespace Reactor\HTTP;

class RequestFactory {

    function buildFromGlobals() {
        return new Request(
            $_GET,
            $_POST,
            null,
            $_FILES,
            $_COOKIE,
            $_SERVER
        );
    }

    function build() {
        $request = new Request();
        $request->GET = new ParamenterBag();
    }

}
