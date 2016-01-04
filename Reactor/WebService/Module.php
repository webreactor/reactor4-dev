<?php

namespace Reactor\WebService;

class Module extends \Reactor\Application\Module {

    public function handleGlobalRequest() {
        $this->core->handleRequest($this->request_factory->buildFromGlobals());
    }

}
