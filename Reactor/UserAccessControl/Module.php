<?php

namespace Reactor\UserAccessControl;

class Module extends \Reactor\Application\Module {

    public function get($user, $path = 'application') {
        return new UserExecuter($user, $this->get($path));
    }

}
