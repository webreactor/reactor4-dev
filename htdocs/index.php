<?php

$start = microtime(true);
$app = include '../bootstrap.php';
echo (microtime(true) - $start) ."\n";
$app->cache->set('aaa', 60);
echo $app->cache->get('aaa');
//$m = $app;
//$m->__sleep();
//var_export($m);
//echo "READY\n\n\n";
//echo (microtime(true) - $start) ."\n";
//var_export($app->getByPath('web_service/exp_compiler')->compile_exp('[$test.123, 123, $asd."asd/as"das"]'));
//print_r($app->getByPath('web_service/exp_compiler')->compiler->errors());
echo (microtime(true) - $start) ."\n";
$app->web_service->handleGlobalRequest();
echo (microtime(true) - $start) ."\n";
