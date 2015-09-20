<?php
$app = include '../bootstrap.php';
$app->reset();

// phpinfo();
// print_r(getallheaders());

// $gekkon = new \Reactor\Gekkon\Gekkon(BASE_DIR, BASE_DIR.'tpl_bin', 'Mod/News/tpl/');
// $gekkon->display('news.tpl');
$app->dispatcher->dispatch( new \Reactor\Events\Event("user.deleted") );

$app->view->register('time', time());
$app->view->display('test.tpl');