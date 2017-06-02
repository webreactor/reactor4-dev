<?php

namespace Reactor\AccessControl;

class Module extends \Reactor\Application\Module {

    public function init() {
        $root = $this->getRoot();
        $root->get('service_wrappers')['access_control'] = new ServiceWrapper();
        $this->set('access_control_list', new AccessControlList());
        $root->set('access_control', new AccessControl($this->get('user'), $this->get('access_control_list')));
    }

    public function getService($container) {
        parent::getService($container);
        return $this->get('access_control');
    }

}
