<?php

define('start', microtime(true));
$last = start;
function profiling($msg = null) {
    global $last;
    $now = microtime(true);
    if ($msg !== null)
    echo ' delta '.round($now - $last, 5) ." $msg\n";
    $last = $now;
}


function test($val1, $val2, $val3) {
    return $val1+$val2+$val3;
}

$rounds =1000000;


profiling();
for ($i = 0; $i < $rounds; $i++) { 
    test(1,2,3);
}
profiling('native end');



profiling();
$func = 'test';
for ($i = 0; $i < $rounds; $i++) { 
    $func(1,2,3);
}
profiling('var end');


profiling();
for ($i = 0; $i < $rounds; $i++) { 
    call_user_func($func, 1, 2, 3);
}
profiling('call_user_func end');


profiling();
$arg = array(1, 2, 3);
for ($i = 0; $i < $rounds; $i++) { 
    call_user_func_array($func, $arg);
}
profiling('call_user_func_array end');
