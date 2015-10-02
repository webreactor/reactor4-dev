<?php

define('BASE_DIR', __dir__.'/');

include BASE_DIR.'vendor/autoload.php';
$_start = microtime(true);
// $app = new \Mod\Application\Application();
echo "\n<br>Full app:".(microtime(true) - $_start)."<br>";
// $app->__sleep();
// print_r($app);
// file_put_contents(__dir__.'/cached-app.php', 
// "<?php
// return ".var_export($app, true).';');


$_start = microtime(true);
$app = include __dir__.'/cached-app.php';
echo "\n<br>Cached app:".(microtime(true) - $_start)."<br>";
return $app;
