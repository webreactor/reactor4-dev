<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Core extends MultiService {

    function handleRequest($request) {
        try {
            $this->execute($request);
        } catch (\Exception $e) {
            if (!headers_sent()) {
                header("HTTP/1.0 500 Couldn't make it");
            } else {
                die("Unexpected error");
            }
            error_log($e->getMessage().' '.$e->getCode().': '.strstr($e->getTraceAsString(), "\n", true));
        }
    }

    function execute($request) {
        $route = new RouterContext($request->link->path);
        $req_res = new RequestResponse($request, new Response(), $route);
        $this->app['router']->routeRequest($req_res);
        if (!empty($route->target)) {
            if (isset($route->target['handler'])) {
                $handler = $route->getTarget('handler', 'index');
                $rez = $this->callService($handler[0], $handler[1], array($req_res));
                if ($rez === false || $req_res->response->code != 200) {
                    // something went wrong
                    // handle 4xx 5xx errors
                }
            }
        }
        $render = $route->getTarget('render', 'render', 'render');
        $this->callService($render[0], $render[1], array($req_res));
    }

}
