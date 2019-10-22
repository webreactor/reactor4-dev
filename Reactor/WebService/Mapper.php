<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;
use Reactor\Tools\StringTools;

class Mapper extends MultiService {

    public function map($request_response) {
        $map = $request_response->route->getTarget('map', null);
        if (empty($map)) {
            return array($request_response);
        }
        return $this->mapValues($request_response, $map);
    }

    public function mapValues($request_response, $map) {
        $values = array();
        foreach ($map as $key => $define) {
            $define += array(null, null, null, null);
            $handler = 'getFrom'.$define[0];
            $value = $this->$handler($request_response, $define);
            if ($value === null) {
                throw new PageNotFoundException("Missing $handler $key argument", 1);
            }
            $values[] = $value;
        }
        return $values;
    }

    public function getFromStatic($request_response, $define) {
        return $define[1];
    }

    public function getFromService($request_response, $define) {
        $data = $this->app->getByPath($define[1]);
        return $this->getFromData($data, $define);
    }

    public function getFromCall($request_response, $define) {
        $args = (array)$define[3];
        $args[] = $request_response;
        return $this->app->callService($define[1], $define[2], $args);
    }

    public function getFromGet($request_response, $define) {
        $data = $request_response->request->get;
        return $this->getFromData($data, $define);
    }

    public function getFromPost($request_response, $define) {
        $data = $request_response->request->post;
        return $this->getFromData($data, $define);
    }

    public function getFromVariable($request_response, $define) {
        $data = $request_response->route->variables;
        return $this->getFromData($data, $define);
    }

    public function getFromData($data, $define) {
        if ($define[1] === null) {
            return $data;
        }
        if (isset($data[$define[1]])) {
            $control = $define[3];
            if (is_array($define[3])) {
                $control[0] = $this->app->getByPath($control[0]);
            } else {
                $control = '\\Reactor\\Tools\\ValueControl::'.$control;
            }
            if(!$control($data[$define[1]])) {
                throw new PageNotFoundException("Failed format check $control {$define[1]}", 1);
            }
            return $data[$define[1]];
        }
        return $define[2];
    }

}


/*

map:
    - [source, key, default, format]

Example:

map:
    - [get, page, 1, natural]
    - [static, 10] // just 10
    - [values, pk_user, null, /user_service, isUser] # service will check value 
    - [post, null]  # returns whole post

sources:
    get, post, valuable, static, service, call

format for "call" is different
    [ call, /service/path, method, [args] ] 
and req_res will be added as the last argument

formats:
    string, number, integer, natural, array


*/
