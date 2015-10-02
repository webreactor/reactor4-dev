<?php

namespace Reactor\Common\Traits;

trait Exportable {
    
    public function restore_state($state) {
        foreach ($state as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function __set_state($state) {
        $obj = new static();
        $obj->restore_state($state);
        return $obj;
    }

}
