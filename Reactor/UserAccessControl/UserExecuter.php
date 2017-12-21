<?php

namespace Reactor\UserAccessControl;

class UserExecuter {
    protected $user;
    protected $container;

    public function __construct($user, $container) {
        $this->user = $user;
        $this->container = $container;
    }

    public function execute($service_path, $method, $arguments = []) {
        $service = $this->tryGetService($service_path, $method, $arguments);
        if ($service !== false) {
            return call_user_func_array(array($service, $method), $arguments);
        }
        throw new Exception("User has no rights to execute this");
    }

    public function hasAccess($service_path, $method, $arguments = []) {
        return $this->tryGetService($service, $method, $arguments) !== false;
    }


    protected function tryGetService($service, $method, $arguments = []) {
        $service = $this->container->getByPath($service_path);
        if ($service instanceof OpenAccessControl) {
            return $service;
        }
        return $service;
        

        return false;
    }

}
