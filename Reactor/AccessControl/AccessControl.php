<?php

namespace Reactor\AccessControl;

class AccessControl implements AccessControlInterface {

    protected $user;

    public function __construct($user, $container, $acl_dao) {
        $this->user = $user;
        $this->container = $container;
        $this->acl_dao = $acl_dao;
    }

    public function hasAccess($service_name, $method_name, $arguments = array()) {
        $method_permission = $this->acl_dao->getMethod($this->user->getGroups(), $service_name, $method_name);
        if ($method_permission !== false) {
            if (is_string($method_permission)) {
                $handler = $this->container->getByPath($method_permission);
                return $handler->hasAccess($user, $name, $method_name, $arguments);
            }
            return true;
        }
        return false;
    }

}
