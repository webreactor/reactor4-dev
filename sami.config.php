<?php

// https://github.com/FriendsOfPHP/Sami

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = __DIR__.'/Reactor');


return new Sami($iterator, array(
    'theme'                => 'default',
    'title'                => 'Reactor 4',
    'build_dir'            => __DIR__.'/docs',
    'cache_dir'            => __DIR__.'/vendor/tmp',
    'default_opened_level' => 1,
));