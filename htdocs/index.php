<?php
$_start = microtime(true);

$app = include '../bootstrap.php';
//$app->reset();

// file_put_contents(__dir__.'/cached-app.php', 
// "<?php
// return ".var_export($app, true).';');
// $app = include __dir__.'/cached-app.php';

// die('ok');
$factory = new \Reactor\HTTP\RequestFactory();
$request = $factory->buildFromGlobals();
print_r($request->query->getString('query'));
//die();
// phpinfo();
// print_r(getallheaders());

// $gekkon = new \Reactor\Gekkon\Gekkon(BASE_DIR, BASE_DIR.'tpl_bin', 'Mod/News/tpl/');
// $gekkon->display('news.tpl');

$app->dispatcher->dispatch( new \Reactor\Events\Event("user.deleted") );

$app->view->register('time', time());

$app->view->display('test.tpl');
echo "\n<br>Total:".(microtime(true) - $_start)."<br>";