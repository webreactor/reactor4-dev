<?php

namespace Reactor\WebService;

class Core {

    public
        $router,
        $controller_manager,
        $render,
        $dispatcher,
        $tree;

    function handleRequest($request, $response) {
        $this->router->routeRequest($request, $this->tree);
        $this->controller_manager->handleRequest($request, $response);
        $this->render->render($request, $response);
    }
}
