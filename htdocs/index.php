<?php
$app = include '../bootstrap.php';
$app->reset();

echo $app->time->get();

$app->view->register('time', time());
$app->view->display('test.tpl');