<?php

namespace Reactor\WebService;

class Module extends \Reactor\Application\Module {

    public function onLoadDefaults() {
        $this->router = new Router();
        $this->mapper = new Mapper();
        $this->render = new Render();
        $this->templater = new \Reactor\Gekkon\Module\Service();
        $this->error_handler = new ErrorHandler();
        $this->core = new Core();
        $this->tools = new Tools();
        $this->url = new UrlBuilder();
    }

    public function handleGlobalRequest() {
        $this->core->handleRequest(RequestFactory::buildFromGlobals());
    }

}
