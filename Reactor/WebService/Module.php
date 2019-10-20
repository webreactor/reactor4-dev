<?php

namespace Reactor\WebService;

use \Reactor\ContentAdapter\FormBuilder;

class Module extends \Reactor\Application\Module {

    public function onUse() {
        $this->router = new Router();
        $this->mapper = new Mapper();
        $this->render = new Render();
        $this->templater = new \Reactor\Gekkon\Module\Service();
        $this->error_handler = new ErrorHandler();
        $this->core = new Core();
        $this->url = new UrlBuilder();
        $this->form = new FormBuilder();
    }

    public function handleGlobalRequest() {
        $this->core->handleRequest(RequestFactory::buildFromGlobals());
    }

}
