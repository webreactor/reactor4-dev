<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Tools extends MultiService {

    function buildUrl($data) {
        return $this->app->get('url')->buildUrl($data);
    }

}
