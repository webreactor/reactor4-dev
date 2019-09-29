<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;
use Reactor\Common\Tools\StringTools;

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
            $handler = 'getFrom'.$define[0];
            $value = $this->$handler($request_response, $define);
            if ($value === null) {
                throw new PageNotFoundException("Error Processing Request", 1);
            }
            $values[] = $value;
        }
        return $values;
    }

    public function getFromGet($request_response, $define) {
        $data = $request_response->request->get;
        return $this->getFromData($data, $define);
    }

    public function getFromPost($request_response, $define) {
        $data = $request_response->request->post;
        return $this->getFromData($data, $define);
    }

    public function getFromURL($request_response, $define) {
        $data = $request_response->route->values;
        return $this->getFromData($data, $define);
    }

    public function getFromData($data, $define) {
        if ($define[1] === null) {
            return $data;
        }
        if (isset($data[$define[1]])) {
            $control = 'ControlValue'.$define[3];
            return $this->$control($data[$define[1]], $define[2]);
        }
        return $define[2];
    }

    public function ControlValueString($value, $default) {
        if (empty($value)) {
            return $default;
        }
        return StringTools::sanitizeBin($value);
    }

    public function ControlValueInteger($value, $default) {
        if ("$value" === ''.intval($value)) {
           return 0 + $value;
        }
        return $default;
    }

    public function ControlValueNumber($value, $default) {
        if (is_numeric($value)) {
            return 0 + $value;
        }
        return $default; 
    }

    public function ControlValueArray($value, $default) {
        if(is_array($value)) {
            return $value;
        }
        return $default;
    }

}
