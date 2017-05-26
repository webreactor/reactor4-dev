<?php

namespace Reactor\AccessControl;

class AccessControlInterface {

    public function hasAccess($name, $method_name, $arguments = array());

}