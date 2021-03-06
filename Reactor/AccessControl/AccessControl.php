<?php

namespace Reactor\AccessControl;

use Reactor\ServiceContainer\ServiceProviderInterface;

class AccessControl implements AccessControlInterface {

    protected $user;
    protected $acl;
    protected $container;

    public function __construct($container, $user, $acl) {
        $this->container = $container;
        $this->user = $user;
        $this->acl = $acl;
    }

    public function hasAccess($service_name, $method_name, $arguments = array()) {
        $method_permission = $this->acl->getMethod($this->user, $service_name, $method_name);
        if ($method_permission !== true) {
            if (is_string($method_permission)) {
                $handler = $this->container->getByPath($method_permission);
                return $handler->hasAccess($this->user, $name, $method_name, $arguments);
            }
            return false;
        }
        return true;
    }

    public function getServices() {
        $this->acl->getServices($this->user);
    }

    public function getMethods($service_name) {
        $this->acl->getMethods($this->user, $service_name);
    }

}
