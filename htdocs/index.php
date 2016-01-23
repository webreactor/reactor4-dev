<?php

$start = microtime(true);
$app = include '../bootstrap.php';
//$app->cache->set('aaa', 600);
//echo $app->cache->get('aaa');
// echo (microtime(true) - $start) ."\n";
$m = $app;
$m->__sleep();
//var_export($m);
//echo "READY\n\n\n";
//echo (microtime(true) - $start) ."\n";
//$controllers = $app->getByPath('controllers');
//$controllers->__sleep();
//print_r($app->getByPath('web_service/exp_compiler')->compiler->errors());
// echo (microtime(true) - $start) ."\n";
 $app->web_service->handleGlobalRequest();
// $app->dispatcher->raise('user.deleted', array('test'));
// echo (microtime(true) - $start) ."\n";
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;
echo '<div style="border: 1px solid black;padding:10px;width:300px">'.$count.'</div>';
$_SESSION['count'] = ++$count;
