<?php

namespace Reactor\WebApp;

class WebApp {

    public
        $router,
        $controller_factory,
        $render,
        $events;

    function handleRequest($request) {
        $this->router->routeRequest($request);
        $controller = $this->controller_factory->getController($request);
        $response = $container->handleRequest($request);
        $this->render->render($request, $response);
    }
}
