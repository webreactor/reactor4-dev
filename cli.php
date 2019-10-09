<?php

include __dir__.'/bootstrap.php';

$cliApp = new \Mod\Application\CliApplication();
$cliApp->cli->handleCli($argv);
