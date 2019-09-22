<?php

define('BASE_DIR', __dir__.'/');

include BASE_DIR.'vendor/autoload.php';

include BASE_DIR.'config/Application.php';



// // $app_cache = new \Reactor\Application\ApplicationCacher(BASE_DIR.'var/bin_generated/');

// // return $app_cache->get(
// //     function () {
// //         $app = new \Mod\Application\Application();
// //         $app->configure();
// //         return $app;
// //     }, 'application', false
// // );

// return $app;
