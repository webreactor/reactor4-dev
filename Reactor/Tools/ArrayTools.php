<?php

namespace Reactor\Tools;

class ArrayTools {
    
    static function walkRecursive($data, $callback) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::walkRecursive($value, $callback);
            }
            return $data;
        } 
        return call_user_func($callback, $data);
    }

    static function mergeRecursive($data1, $data2) {
        if (!(is_array($data1) && is_array($data2))) {
            return $data2;
        }
        foreach ($data2 as $key => $value) {
            if (isset($data1[$key])) {
                if (is_integer($key)) {
                    $data1[] = $value;
                } else {
                    $data1[$key] = self::mergeRecursive($data1[$key], $value);
                }
            } else {
                $data1[$key] = $value;
            }
        }
        return $data1;
    }

}
