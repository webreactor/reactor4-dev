<?php

$start = microtime(true);
//echo (microtime(true) - $start) ."\n";
$app = include '../bootstrap.php';

//$m = $app;
//$m->__sleep();
//var_export($m);
//echo "READY\n\n\n";
var_export($app->getByPath('db.connections/connections'));
$app->web_service->handleGlobalRequest();
