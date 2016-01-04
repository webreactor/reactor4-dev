<?php

namespace Reactor\WebService;

class Core {

    protected $request_factory;
    protected $response_sender;

    public function __construct($dispatcher, $router, $render) {
        $this->dispatcher = $dispatcher;
        $this->router = $router;
        $this->render = $render;
    }

    public function handleRequest($request) {
        try {
            $request_response = new RequestResponse($request);
            $this->dispatcher->raise('http.request', $request_response);

            $handler = array($this->router, 'handleRequest');
            $this->process($handler, $request_response);

            $this->render->render($request_response);
            $this->dispatcher->raise('http.sent', $request_response);
        } catch (\Exception $e) { // Not finished run default handler
            die('Caught exception: '. $e->getMessage(). "\n");
        }
    }

    public function process($handler, $request_response) {
        do {
            $this->dispatcher->raise('http.handler', array('handler' => $handler, 'request_response' => $request_response));
            $handler = call_user_func($handler, $request_response);
        } while (!empty($handler));
        $this->dispatcher->raise('http.processed', $request_response);
    }

}
