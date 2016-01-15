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
//var_export($app->getByPath('db.connections/connections'));
echo (microtime(true) - $start) ."\n";
$app->web_service->handleGlobalRequest();
echo (microtime(true) - $start) ."\n";
