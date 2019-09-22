<?php

namespace Reactor\Common\Tools;

class FileSystemTools {

    static function createDir($path, $mod = 0755) {
        $path = rtrim($path, '/');
        if (!is_dir($path)) {
            mkdir($path, $mod, true);
        }
    }
}
