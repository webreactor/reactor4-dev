<?php
$start = microtime(true);



$app = include '../bootstrap.php';

echo (microtime(true) - $start) ." bootstrapped\n";

$app = new \Myproject\Application();
$app->loadConfig();

echo (microtime(true) - $start) ." app loaded\n";

// print_r($app);

//echo "READY\n\n\n";
//echo (microtime(true) - $start) ."\n";
// echo (microtime(true) - $start) ."\n";
//$app->web_service->handleGlobalRequest();
$app->get('dispatcher')->raise('user.deleted', array('test'));

echo (microtime(true) - $start) ."\n";
//print_r($app);