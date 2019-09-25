<?php

namespace Reactor\WebService;

class Module extends \Reactor\Application\Module {

    public function onUse() {
        $this->set('router', new Router()); // uses site_tree
        $this->set('core', new Core());
        $this->set('render', new Render());
        $this->set('template_engine', new \Reactor\Gekkon\Module\Service());
    }

    public function handleGlobalRequest() {
        $this['core']->handleRequest(RequestFactory::buildFromGlobals());
    }

}
