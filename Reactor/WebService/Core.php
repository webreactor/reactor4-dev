<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Core extends MultiService {

    public function handleRequest($request) {
        try {
            try {
                $this->events = $this->app->events;
                set_error_handler(array($this, 'handlePHPError'));
                $route = new RouterContext($request->link->path);
                $this->app->req_res = $req_res = new RequestResponse($request, new Response(), $route);
                $this->execute($req_res);
            } catch (\Throwable $error) {
                $this->handleError($error, $req_res);
            }
        } catch (\Throwable $error) {
            $this->lastStandError($error);
        }
    }

    public function execute($req_res) {
        $this->events->raise('web.request.received', $req_res);
        $this->app->router->routeRequest($req_res);
        $this->execAndRender($req_res);
        $this->events->raise('web.request.served', $req_res);
    }

    public function execAndRender($req_res) {
        $route = $req_res->route;
        $count = 10;
        while ($route->new_target && $count-- > 0) {
            $route->new_target = false;
            $this->events->raise('web.request.routed', $req_res);
            $handler = $route->getTarget('handler', array(null, 'index'));
            if ($handler[0] !== null) {
                $mapper = $route->getTarget('mapper', array('mapper', 'map'));
                $values = $this->callService($mapper[0], $mapper[1], array($req_res));
                $data = $this->callService($handler[0], $handler[1], $values);
                if ($req_res->response->body === null) {
                    $req_res->response->body = $data;
                }
            }
            $this->events->raise('web.request.handled', $req_res);
            profiling('logic is done');
            if (!$route->new_target) {
                $this->app->render->render($req_res);
            }
        }
    }

    public function handlePHPError($errno, $errstr, $errfile, $errline) {
        throw new \ErrorException($errstr, $errno, $errno, $errfile, $errline);
    }

    public function handleError($error, $req_res) {
        if (!$req_res->route->switchToError($error)) {
            throw $error;
        }
        $this->execAndRender($req_res);
    }

    public function lastStandError($error) {
        if (!headers_sent()) {
            if ($error instanceof PageNotFoundException) {
                header("HTTP/1.0 404 Couldn't make it");
            } else {
                header("HTTP/1.0 500 Couldn't make it");
            }
        }
        error_log($error->getMessage().' '.$error->getCode().': '.strstr($error->getTraceAsString(), "\n", true));
        die('Service will come back soon');
    }

}
