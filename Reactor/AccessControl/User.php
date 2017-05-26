<?php

namespace Reactor\AccessControl;

class User {

    protected $id;
    protected $groups = array();

    function __construct($id, $groups) {
        $this->id = $id,
        $this->groups = $groups;
    }

    public function getGroups() {
        return $this->groups;
    }
}
