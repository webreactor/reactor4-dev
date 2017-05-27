<?php


function include_dir($path)
{
    $path = rtrim($path, '/');
    if(is_dir($path))
    {
        $dirs = array();
        foreach(scandir($path) as $file)
        {
            if($file[0] != '.')
            {
                $to_include = $path.'/'.$file;
                if(is_dir($to_include)) $dirs[] = $to_include;
                elseif(strtolower(strrchr($to_include, '.')) === '.php')
                {
                    include_once $to_include;
                }
            }
        }
        foreach($dirs as $dir) include_dir($dir);
    }
}


$app = include '../bootstrap.php';
include_dir(__dir__.'/../Reactor');
include_dir(__dir__.'/../Mod');

// echo (microtime(true) - $start) ."\n";
$start = microtime(true);
$app = new \Myproject\Application();
$app->loadConfig();

echo (microtime(true) - $start) ."\n";

// print_r($app);

//echo "READY\n\n\n";
//echo (microtime(true) - $start) ."\n";
//$controllers = $app->getByPath('controllers');
//$controllers->__sleep();
//print_r($app->getByPath('web_service/exp_compiler')->compiler->errors());
// echo (microtime(true) - $start) ."\n";
//$app->web_service->handleGlobalRequest();
$app['dispatcher']->raise('user.deleted', array('test'));
echo (microtime(true) - $start) ."\n";
//print_r($app);