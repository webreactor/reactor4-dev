<?php

namespace Reactor\AccessControl;

class Module extends \Reactor\Application\Module {

    public function init() {
        $root = $this->getRoot();
        if (!$this->has('access_control_list')) {
            $this->set('access_control_list', new AccessControlList());    
        }
        $root->set('access_control', new AccessControl($this->get('user'), $this->get('access_control_list')));
    }

    public function getService($container) {
        parent::getService($container);
        return $this->get('access_control');
    }

}
