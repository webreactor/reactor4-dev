<?php

namespace Reactor\AccessControl;

class AccessControlList {

    public function getMethod($groups, $service_name, $method_name) {
        echo "AccessControl > $service_name -> $method_name\n";
        return true;
    }

}
