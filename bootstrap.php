<?php

define('BASE_DIR', __dir__.'/');

include BASE_DIR.'vendor/autoload.php';

$app_cache = new \Reactor\Application\ApplicationCacher(BASE_DIR.'var/');

return $app_cache->get(
    function () {
        return new \Mod\Application\Application();
    }, 'application', false
);
