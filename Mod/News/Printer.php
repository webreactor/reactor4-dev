<?php

namespace Mod\News;

class Printer {
    public function handle($rr) {
        // $rr->response->body = array('we', 'are', 'here');
        // print_r(func_get_args());
        return array('data'=>array());
    }

    public function display($data) {
        echo "display\n";
        print_r($data);
    }

}
