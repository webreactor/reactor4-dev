<?php

namespace Reactor\WebService;

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

}
