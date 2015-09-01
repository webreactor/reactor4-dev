<?php

$app = include '../bootstrap.php';
$app->reset();
//print_r($app);

$gekkon = new \Reactor\Gekkon\Gekkon(__dir__.'/tpl/',__dir__.'/tpl_bin/');
$gekkon->register('time', time());
$gekkon->display('test.tpl');