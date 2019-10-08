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
// $t = new ArrayObject(array(1));
// $t = array(1);
// for ($i=1;$i<100000;$i++) {
//     $t[$i%10] = $t[($i-1)%10];
// }




// foreach ($t as $path) {
//     $module = $app->getByPath($path);
//     echo $path.' - '.$module->getDir()."\n";
// }
// print_r($t);


$app->get('web')->handleGlobalRequest();

profiling('end');
