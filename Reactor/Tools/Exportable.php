<?php

namespace Reactor\Tools;

trait Exportable {
    
    public function restoreState($state) {
        foreach ($state as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function __set_state($state) {
        $obj = new static();
        $obj->restoreState($state);
        return $obj;
    }

}
