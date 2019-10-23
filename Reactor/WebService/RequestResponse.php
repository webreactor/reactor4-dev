<?php

namespace Reactor\WebService;

use \Reactor\Tools\ValueControl;

class RequestResponse {

    public $request;
    public $response;
    public $route;

    public function __construct($request, $response = null, $route = null) {
        $this->request = $request;
        $this->response = $response;
        $this->route = $route;
    }

    public function return404($message) {
        throw new PageNotFoundException($message);
    }

    public function location($url, $code = 302) {
        $this->response->headers['Location'] = $url;
        $this->response->code = $code;
        unset($this->route->target['template']);
    }

    public function getVariable($name, $check = null, $default = '__return_404__') {
        $rez = null;
        if (isset($this->route->variables[$name])) {
            $rez = $this->route->variables[$name];
        }
        if (isset($this->request->get[$name])) {
            $rez = $this->request->get[$name];
        }
        if ($rez !== null && $check !== null) {
            if (is_string($check) && $check[0] != '\\') {
                $check = '\\Reactor\\Tools\\ValueControl::'.$check;
            }
            if (!$check($rez)) {
                $rez = null;
            }
        }
        if ($rez !== null) {
            return $rez;
        }
        if ($default === '__return_404__') {
            $this->return404("Failed to get variable $name");
        }
        return $default;
    }

}
