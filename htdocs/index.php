<?php

$_start = microtime(true);
$app = include '../bootstrap.php';

$app->web_service->handleGlobalRequest();