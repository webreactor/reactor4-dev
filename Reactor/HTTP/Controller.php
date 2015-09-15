<?php

namespace Reactor\HTTP;

use \Reator\Events\Event;

class Controller {

    protected $request_factory;
    protected $response_sender;

    public function handleGlobalRequest() {
        $request = $this->request_factory->build();
        $this->handleRequest($request);
    }

    public function handleRequest($request) {
        try {

            $request_responce = new RequestResponce($request);
            $this->dispatcher->dispatch(new Event('http.request', $request_responce));

            $handler = $this->router->getHandler($request_responce);
            $this->dispatcher->dispatch(new Event('http.handler', $handler));

            $handler->process();
            $this->dispatcher->dispatch(new Event('http.processed', $request_responce));

            $this->response_sender->send($request_responce->response);
            $this->dispatcher->dispatch(new Event('http.sent', $request_responce));

        } catch (\Exception $e) { // Not finished run default handler
            print_r($exchange);
            die('Caught exception: ',  $e->getMessage(), "\n");
        }
    }

}
