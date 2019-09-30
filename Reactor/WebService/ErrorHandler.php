<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class ErrorHandler extends MultiService {

    public function index($req_res) {
        if ($req_res->response->code == 200) {
            $error = $req_res->route->error;
            if ($error instanceof PageNotFoundException) {
                $req_res->response->code = 404;
            } else {
                $req_res->response->code = 500;
            }
        }
    }
}
