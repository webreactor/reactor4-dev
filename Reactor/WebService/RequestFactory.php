<?php

namespace Reactor\WebService;

class RequestFactory {

    function buildFromGlobals() {
        $request = new Request();

        $request->setPost($_POST);
        $request->setGet($_GET);
        $request->setCookies($_COOKIE);
        $request->setFiles($_FILES);

        $request->setHeaders($this->parseHeaders($_SERVER));

        $request->method = $_SERVER['REQUEST_METHOD'];

        $request->link->scheme = $_SERVER['REQUEST_SCHEME'];
        $request->link->host = $_SERVER['HTTP_HOST'];
        $request->link->port = $_SERVER['SERVER_PORT'];
        $request->link->path = strstr($_SERVER['REQUEST_URI'].'?', '?', true);
        $request->link->query = $_SERVER['QUERY_STRING'];

        return $request;
    }

    public function parseHeaders($data) {
        $headers = array();
        $custom_headers = array(
            'CONTENT_LENGTH' => true,
            'CONTENT_TYPE' => true
        );
        foreach ($data as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[substr($key, 5)] = $value;
            } elseif (isset($custom_headers[$key])) {
                $headers[$key] = $value;
            }
        }
        return $headers;
    }

}
