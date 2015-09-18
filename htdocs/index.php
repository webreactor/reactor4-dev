<?php
$app = include '../bootstrap.php';
$app->reset();

phpinfo();
print_r(getallheaders());

//$app->dispatcher->dispatch( new \Reactor\Events\Event("user.deleted") );

//$app->view->register('time', time());
//$app->view->display('test.tpl');