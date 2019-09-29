<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Render extends MultiService {

    public function render($req_res) {
        $response = $req_res->response;
        if (!headers_sent()) {
            if ($response->code != 200) {
                http_response_code($response->code);
            }
            foreach ($response->headers as $key => $value) {
                header($key.': '.$value);
            }
        }
        $template = $req_res->route->getTarget('template');
        if ($template !== null) {
            $templater = $this->app['templater'];
            $templater->register('data', $response->body);
            $templater->register('request_response', $req_res);
            $templater->display($template[1], false, $template[0]);
        }
    }

}
