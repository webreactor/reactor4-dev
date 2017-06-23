<?php

namespace Reactor\WebService;

class Core {

    protected $dispatcher;
    protected $router;
    protected $render;

    public function __construct($dispatcher, $router, $render) {
        $this->dispatcher = $dispatcher;
        $this->router = $router;
        $this->render = $render;
    }

    public function handleRequest($request) {
        try {
            $request_response = new RequestResponse($request);
            $this->dispatcher->raise('web-app.received', $request_response);

            $this->router->route($request_response);
            $this->dispatcher->raise('web-app.routed', $request_response);

            $this->render->render($request_response);
            $this->dispatcher->raise('web-app.rendered', $request_response);
        } catch (\Exception $e) { // Not finished pass to exception router
            die('WebApplication Core caught exception: '. $e->getMessage(). "\n");
        }
    }

}
