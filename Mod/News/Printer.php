<?php

namespace Mod\News;

class Printer {
    public function handler($rr) {
        $rr->response->body = array('we', 'are', 'here');
    }

    public function display($data) {
        echo "display\n";
        print_r($data);
    }

}
