<?php

namespace Reactor\AccessControl;

class Module extends \Reactor\Application\Module {

    public function onLoad() {
        $root = $this->getRoot();
        $root->set('user', new \Reactor\AccessControl\User(1, array('root')));
        $root->get('service_wrappers')['access_control'] = new ServiceWrapper();
    }

    public function init() {
        $this->set('access_control_list', new AccessControlList());
        $this->set('access_control', new AccessControl($this->get('user'), $this->get('access_control_list')));
    }

    public function getService($container) {
        parent::getService($container);
        return $this->get('access_control');
    }

}
