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
        $this->dispatcher->raise('web-app.init');
    }

    public function handleRequest($request) {
        try {
            $request->metadata['render_task'] = new RenderTask();
            $request_response = new RequestResponse($request);
            $this->dispatcher->raise('web-app.received', $request_response);

            $this->dispatcher->raise('web-app.router.before', $request_response);
            $this->route($this->router, $request_response);
            $this->dispatcher->raise('web-app.routed', $request_response);

            $this->render->render($request_response);
            $this->dispatcher->raise('web-app.rendered', $request_response);
        } catch (\Exception $e) { // Not finished pass to exception router
            die('WebApplication Core caught exception: '. $e->getMessage(). "\n");
        }
    }

    public function route($router, $request_response) {
        $render_task = $request_response->request->metadata['render_task'];
        while ($router instanceof RouterInterface && $render_task->routable) {
            $router_class = get_class($router);
            $router = $router->route($request_response);
        };
    }

}
