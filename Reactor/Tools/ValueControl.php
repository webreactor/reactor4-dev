<?php

namespace Reactor\Tools;

class ValueControl {

    static function isString($value) {
        return "$value" === StringTools::sanitizeBin($value);
    }

    static function isInteger($value) {
        return "$value" === ''.intval($value);
    }

    static function isNatural($value) {
        return ("$value" === ''.intval($value) && $value > 0);
    }

    static function isZNatural($value) {
        return ("$value" === ''.intval($value) && $value >= 0);
    }

    static function isNumber($value) {
        return is_numeric($value); 
    }

    static function isArray($value) {
        return is_array($value);
    }

}
