<?php

namespace Reactor\WebService;

class Module extends \Reactor\Application\Module {

    public function handleGlobalRequest() {
        $this->core->handleRequest($this->request_factory->buildFromGlobals());
    }

    public function execute($service, $method, $arguments = [], $module = null, $template = null, $template_arguments = []) {
        $this->application->getByPath($service);
        return $rez;
    }

}
