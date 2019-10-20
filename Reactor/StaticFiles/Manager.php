<?php

namespace Reactor\StaticFiles;

use \Reactor\Application\Module;
use \Reactor\Tools\FileSystemTools;

class Manager {
    
    public function listModules($app) {
        $list = array('/');
        $module_cnt = 0;
        while ($module_cnt < count($list)) {
            $module = $app->getByPath($list[$module_cnt]);
            foreach ($module->getKeysDirect() as $key) {
                $element = $module[$key];
                if ($element instanceof Module) {
                    $full_name = $element->getFullName();
                    if (!in_array($full_name, $list)) {
                        $list[] = $full_name;
                    }
                }
            }
            $module_cnt++;
        }
        return $list;
    }

    public function deployStatics($app, $destination, $static_folder = 'static') {
        $destination = rtrim($destination, '/').'/';
        $modules = $this->listModules($app);
        foreach ($modules as $path) {
            $module = $app->getByPath($path);
            $dir = $module->getDir();
            $source = $dir.$static_folder.'/';
            if (is_dir($source)) {
                FileSystemTools::copyDir($source, $destination);
            }
        }
    }

}

// $m = new \Reactor\StaticFiles\Manager();
// $t = $m->listModules($app);
// for ($i=0; $i<10000; $i++) {
//     $app->web->getByPath('/news/printer');
//     $app->web->test = 1;
// }

