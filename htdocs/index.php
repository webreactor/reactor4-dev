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

$app = new \Myproject\Application();
profiling('app created');
$app->loadConfig();
// print_r($app);
profiling('app loaded');


// $m = new \Reactor\StaticFiles\Manager();

// $t = $m->listModules($app);


// foreach ($t as $path) {
//     $module = $app->getByPath($path);
//     echo $path.' - '.$module->getDir()."\n";
// }
// print_r($t);


$app['web']->handleGlobalRequest();

profiling('end');
