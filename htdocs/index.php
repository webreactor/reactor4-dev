<?php

$_start = microtime(true);
$app = include '../bootstrap.php';

print_r($app);
$app->view;
die('ok');


// die('ok');
echo "\n<br>Total:".(microtime(true) - $_start)."<br>";
$factory = new \Reactor\HTTP\RequestFactory();
$request = $factory->buildFromGlobals();
print_r($request->query->getString('query'));
//die();
// phpinfo();
// print_r(getallheaders());

// $gekkon = new \Reactor\Gekkon\Gekkon(BASE_DIR, BASE_DIR.'tpl_bin', 'Mod/News/tpl/');
// $gekkon->display('news.tpl');
echo "\n<br>Total:".(microtime(true) - $_start)."<br>";
$app->dispatcher->dispatch( new \Reactor\Events\Event("user.deleted") );
echo "\n<br>Total:".(microtime(true) - $_start)."<br>";
$app->view->register('time', time());
echo "\n<br>Total:".(microtime(true) - $_start)."<br>";
$app->view->display('test.tpl');
echo "\n<br>Total:".(microtime(true) - $_start)."<br>";