<?php

$app = include '../bootstrap.php';
$app->reset();
//print_r($app);

$app->view->register('time', time());
$app->view->display('test.tpl');