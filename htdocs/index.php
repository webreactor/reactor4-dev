<?php

$start = microtime(true);
//echo (microtime(true) - $start) ."\n";
$app = include '../bootstrap.php';

$app->web_service->handleGlobalRequest();
