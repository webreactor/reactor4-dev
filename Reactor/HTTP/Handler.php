<?php

namespace Reactor\HTTP;

class Handler {
    protected $request_factory;
    protected $response_sender;

    public function __construct($module) {
        $this->module = $module;
        $this->dispatcher = $module->get('dispatcher');
    }

    public function handleGlobalRequest() {
        $this->handleRequest($this->module->get('global_request'));
    }

    public function handleRequest($request) {
        try {
            $request_response = new RequestResponse($request);
            $this->dispatcher->raise('http.request', $request_response);

            $handler = array($this->router, 'getHandler');
            $this->process($handler, $request_response);

            $this->response_sender->send($request_response->response);
            $this->dispatcher->raise('http.sent', $request_response);
        } catch (\Exception $e) { // Not finished run default handler
            print_r($exchange);
            die('Caught exception: '.  $e->getMessage(). "\n");
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