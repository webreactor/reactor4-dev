<?php

include '../../bootstrap.php';

define('start', microtime(true));
$last = start;
function profiling($msg) {
    global $last;
    $now = microtime(true);
    echo round($now - start, 7) .' delta '.round($now - $last, 5) ." $msg\n";
    $last = $now;
}

class handler {
    public $id;
    function __construct($id) {
        $this->id = $id;
    }
    function handle($event) {
        echo "handler ".$this->id.' - '.$event->data."\n";
    }
}


$events = new \Reactor\Events\Dispatcher();

$handlers = array();
$x = 30;
for ($i=0; $i < $x; $i++) { 
    $handlers[] = $h = new handler('a'.$i);
    $events->addListener('*', array($h, 'handle'));
}
for ($i=0; $i < $x; $i++) { 
    $handlers[] = $h = new handler('b'.$i);
    $events->addListener('news.*', array($h, 'handle'));
}
for ($i=0; $i < $x; $i++) { 
    $handlers[] = $h = new handler('c'.$i);
    $events->addListener('*.created', array($h, 'handle'));
}
for ($i=0; $i < $x; $i++) { 
    $handlers[] = $h = new handler('c'.$i);
    $events->addListener('*.created.'.$i, array($h, 'handle'));
}

profiling('start');

for ($i=0; $i < 100; $i++) {
    $events->raise('news.created', 'data');
    $events->raise('user.created', 'data');
    $events->raise('news.deleted', 'data');
}

profiling('end');

