<?php
$app = include '../bootstrap.php';
$app->reset();

$app->view->register('time', time());
$app->view->display('test.tpl');