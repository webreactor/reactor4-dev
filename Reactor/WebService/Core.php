<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Core extends MultiService {

    public function handleRequest($request) {
        try {
            try {
                $route = new RouterContext($request->link->path);
                $req_res = new RequestResponse($request, new Response(), $route);
                $this->execute($req_res);
            } catch (\Exception $error) {
                if (!$req_res->route->switchToError($error)) {
                    throw $error;
                }
                $this->execAndRender($req_res);
            }
        } catch (\Exception $error) {
            $this->lastStandError($error);
        }
    }

    public function execute($req_res) {
        $this->app['router']->routeRequest($req_res);
        $this->execAndRender($req_res);
    }

    public function execAndRender($req_res) {
        $route = $req_res->route;
        $count = 10;
        while ($route->new_target && $count-- > 0) {
            $route->new_target = false;
            $handler = $route->getTarget('handler', array(null, 'index'));
            if ($handler[0] !== null) {
                $values = $this->callService('mapper', 'map', array($req_res));
                $this->callService($handler[0], $handler[1], $values);
            }
            if (!$route->new_target) {
                $render = $route->getTarget('render', array('render', 'render'));
                $this->callService($render[0], $render[1], array($req_res));
            }
        }
    }

    public function lastStandError($error) {
        if (!headers_sent()) {
            if ($error instanceof PageNotFoundException) {
                header("HTTP/1.0 404 Couldn't make it");
            } else {
                header("HTTP/1.0 500 Couldn't make it");
            }
        } else {
            die("Unexpected error");
        }
        error_log($error->getMessage().' '.$error->getCode().': '.strstr($error->getTraceAsString(), "\n", true));
    }

}
