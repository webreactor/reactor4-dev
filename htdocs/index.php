<?php
$app = include '../bootstrap.php';
$app->reset();

echo $app->time;
sleep(2);
echo $app->time;

$app->view->register('time', time());
$app->view->display('test.tpl');