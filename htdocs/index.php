<?php

$start = microtime(true);
$app = include '../bootstrap.php';
echo (microtime(true) - $start) ."\n";

// print_r($app);

//echo "READY\n\n\n";
//echo (microtime(true) - $start) ."\n";
//$controllers = $app->getByPath('controllers');
//$controllers->__sleep();
//print_r($app->getByPath('web_service/exp_compiler')->compiler->errors());
// echo (microtime(true) - $start) ."\n";
//$app->web_service->handleGlobalRequest();
$app['dispatcher']->raise('user.deleted', array('test'));
echo (microtime(true) - $start) ."\n";
//print_r($app);