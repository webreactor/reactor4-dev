<?php

namespace Reactor\WebService;

class Module extends \Reactor\Application\Module {

    public function onLoadDefaults() {
        $this->set('router', new Router());
        $this->set('mapper', new Mapper());
        $this->set('render', new Render());
        $this->set('templater', new \Reactor\Gekkon\Module\Service());
        $this->set('error_handler', new ErrorHandler());
        $this->set('core', new Core());
        $this->set('tools', new Tools());
        $this->set('url', new UrlBuilder());
    }

    public function handleGlobalRequest() {
        $this->get('core')->handleRequest(RequestFactory::buildFromGlobals());
    }

}
