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
//$app->get('dispatcher')->raise('user.deleted', array('test'));

$app['config']['web']->exchangeArray([
    'handler',
    'config' => 'index lovely config',
    'nodes' => [
        'news' => ['config' => 'news lovely config',],
        'catalog' => ['config' => 'catalog lovely config',],
    ],
]);


print_r($app['web']['core']->tree);

//$app['web']->handleGlobalRequest();



echo (microtime(true) - $start) ." end\n";
//print_r($app);

