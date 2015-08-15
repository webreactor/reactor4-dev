<?php

define('APP_DIR', __dir__.'/');

include APP_DIR.'vendor/autoload.php';

return new \Reactor\Application\ApplicationLoader(APP_DIR.'config/base.json')->loadApplication();
