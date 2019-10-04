<?php
define('start', microtime(true));
$last = start;
function profiling($msg) {
    global $last;
    $now = microtime(true);
    echo round($now - start, 7) .' delta '.round($now - $last, 5) ." $msg\n";
    $last = $now;
}
$GLOBALS['debug'] = true;
$app = include '../bootstrap.php';
profiling('bootstrapped');

$app = new \Myproject\Application();
profiling('app created');
$app->loadConfig();
// print_r($app);
profiling('app loaded');

$app['web']->handleGlobalRequest();

profiling('end');
