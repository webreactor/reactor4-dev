<?php

namespace Reactor\Common\Tools;

class ArrayTools {
    
    static function warkRecursive($data, $callback) {
        if (is_array($items) || is_a($data, 'Traversable')) {
            foreach ($data as $key => $value) {
                $data[$key] = self::warkRecursive($value, $callback);
            }
            return $data;
        } 
        return call_user_func($callback, $data);
    }

}
