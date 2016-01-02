<?php

$_start = microtime(true);
$app = include '../bootstrap.php';

$app->http->handler->handleGlobalRequest();