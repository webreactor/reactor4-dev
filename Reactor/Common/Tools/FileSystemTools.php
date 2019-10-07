<?php

namespace Reactor\Common\Tools;

class FileSystemTools {

    static function createDir($path, $mod = 0755) {
        $path = rtrim($path, '/');
        if (!is_dir($path)) {
            mkdir($path, $mod, true);
        }
    }

    static function copyDir($src, $dst) {
        $src = rtrim($src, '/').'/';
        $dst = rtrim($dst, '/').'/';
        self::createDir($dst);
        if (is_dir($src) && is_dir($dst)) {
            $dir = opendir($src); 
            while(false !== ($file = readdir($dir))) { 
                if ($file[0] != '.') { 
                    if (is_dir($src.$file) ) { 
                        self::copyDir($src.$file, $dst.$file); 
                    } 
                    else { 
                        copy($src.$file, $dst.$file); 
                    } 
                } 
            } 
            closedir($dir);
            return true;
        }
        return false;
    } 

}
