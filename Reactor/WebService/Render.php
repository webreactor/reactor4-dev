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
        $template_wrap = $req_res->route->getTarget('template_wrap');
        if ($template_wrap !== null || $template !== null) {
            $templater = $this->app['templater'];
            $templater->register('data', $response->body);
            $templater->register('req_res', $req_res);
            $templater->register('template', $template);
            $templater->register('web_tools', $this->app['tools']);
            if ($template_wrap !== null) {
                $template = $template_wrap;
            }
            $templater->display($template[1], false, $template[0]);
        }
    }

}
