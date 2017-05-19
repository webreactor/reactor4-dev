<?php

$start = microtime(true);
$app = include '../bootstrap.php';
// echo (microtime(true) - $start) ."\n";

$c = new \Reactor\ServiceContainer\ServiceContainer();
$s = new \Reactor\ServiceContainer\ServiceContainer();
$s->setParent($c);
$c->set('time', function() {
    return microtime(true);
});
// $c->set('time', function() {
//     return microtime(true);
// });

print_r($c);
echo $s->time."\n";
usleep(100);
echo $s->time."\n";
usleep(100);
print_r($s->get("time"))."\n";
die();
//echo "READY\n\n\n";
//echo (microtime(true) - $start) ."\n";
//$controllers = $app->getByPath('controllers');
//$controllers->__sleep();
//print_r($app->getByPath('web_service/exp_compiler')->compiler->errors());
// echo (microtime(true) - $start) ."\n";
$app->web_service->handleGlobalRequest();
$app->dispatcher->raise('user.deleted', array('test'));
echo (microtime(true) - $start) ."\n";
