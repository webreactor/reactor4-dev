<?php

namespace Reactor\WebComponents;

use Reactor\Application\MultiService;

class MethodController extends MultiService {

    public function handle($req_res) {
        $method = $req_res->request->method;
        $possible_methods = array('GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH');
        if (in_array($method, $possible_methods)) {
            $method = 'on' . $method;
            if (method_exists($this, $method)) {
                return call_user_func(array($this, $method), $req_res);
            }
        }
        return $req_res->return404('HTTP method not allowed');
    }

}
