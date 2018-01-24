<?php

namespace Reactor\WebService;

class Core {

    public
        $router,
        $controller_factory,
        $render,
        $dispatcher,
        $tree;

    function handleRequest($request, $response) {
        $this->router->routeRequest($request, $this->tree);
        $controller = $this->controller_manger->getControllerCallback($request);
        call_user_func($controller, $request, $response);
        $response = $controller->handleRequest($request);
        $this->render->render($request, $response);
    }
}
