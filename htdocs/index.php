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
include '../bootstrap.php';
profiling('bootstrapped');

$app = new \Mod\Application\WebApplication();

profiling('app loaded');

$app->get('web')->handleGlobalRequest();

profiling('end');
