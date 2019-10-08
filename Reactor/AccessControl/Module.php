<?php

namespace Reactor\AccessControl;

class Module extends \Reactor\Application\Module {

    protected $access_control;

    public function onLoad() {
        $root = $this->getRoot();
        $root->set('user', new \Reactor\AccessControl\User(1, array('root')));
    }

    public function init() {
        $this->set('access_control_list', new AccessControlList());
        $this->access_control = new AccessControl($this, $this->get('user'), $this->get('access_control_list'));
    }

    public function provideService($container) {
        parent::provideService($container);
        return $this->access_control;
    }

}
