<?php

namespace Reactor\AccessControl;

interface AccessControlInterface {

    public function hasAccess($name, $method_name, $arguments = array());

}
