<?php

namespace Reactor\WebService;

use Reactor\Common\ValueScope\ValueScopeArray;

class RequestFactory {

    function buildFromGlobals() {
        $server = new ValueScopeArray($_SERVER);
        $request = new Request();

        $request->post = $_POST;
        $request->get = $_GET;
        $request->cookie = $_COOKIE;
        $request->files = $_FILES;

        //$request->setHeaders(self::parseHeaders($server));
        $request->method = $_SERVER['REQUEST_METHOD'];

        $link = new WebLink();
        $link->scheme = $server->get('REQUEST_SCHEME','http');
        $link->host = strstr($server->get('HTTP_HOST',''), ':', true);
        $link->port = $server->get('SERVER_PORT','');
        $link->path = strstr($server->get('REQUEST_URI','').'?', '?', true);
        $link->query = $server->get('QUERY_STRING','');

        $request->link = $link;
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
