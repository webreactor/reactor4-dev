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
        $template = $req_res->route->getTarget('template', null, null);
        if ($template[1] !== null) {
            $render = $this->app['template_engine'];
            $render->register('data', $response->body);
            $render->register('request_response', $req_res);
            $render->display($template[1], false, $template[0]);
        }
    }

}
