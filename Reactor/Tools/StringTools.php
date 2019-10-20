<?php

namespace Reactor\Tools;

class StringTools {

    static function sanitizeBin($str) {
        return preg_replace('/[^\w\pP\pL\s\$]/uis', ' ', trim($str));
    }

    static function buildQueryString($data, $override = array()) {
        return http_build_query(array_merge($data, $override));
    }

}