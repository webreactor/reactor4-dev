<?php

// $start = microtime(true);
$app = include '../bootstrap.php';
$app->websession->register();
session_start();
//echo (microtime(true) - $start) ."\n";
$_SESSION['abc'] = 'test';
var_dump($_SESSION['abc']);
$app->cache->set('aaa', 600);
echo $app->cache->get('aaa');
//$m = $app;
//$m->__sleep();
//var_export($m);
//echo "READY\n\n\n";
//echo (microtime(true) - $start) ."\n";
//$controllers = $app->getByPath('controllers');
//$controllers->__sleep();
//print_r($app->getByPath('web_service/exp_compiler')->compiler->errors());
// echo (microtime(true) - $start) ."\n";
$app->web_service->handleGlobalRequest();
echo (microtime(true) - $start) ."\n";
