<?php

namespace Reactor\Gekkon\Tags\Common;
use \Reactor\Gekkon\Compiler\BaseTag;

class Tag_navigation extends BaseTag {
    function compile($compiler) {
        $args = $compiler->exp_compiler->parse_args($this->args_raw);
        $args = $compiler->exp_compiler->compile_construction_expressions($args);
        if (isset($args['data'])) {
            $args['now'] = $args['data'].'["page"]';
            $args['total'] = $args['data'].'["total_pages"]';
        } else {
            if (!isset($args['now'])) {
                return $compiler->error_in_tag('Missing required argument "now"', $this);
            }
            if (!isset($args['total'])) {
                return $compiler->error_in_tag('Missing required argument "total"', $this);
            } 
        }
        if (!isset($args['frame'])) {
            $args['frame'] = 5;
        }

        $id = $compiler->getUID();
        $now = $args['now'];
        $total = $args['total'];
        $frame = $args['frame'];
        $from = '$_gkn_navi_from'.$id;
        $till = '$_gkn_navi_till'.$id;
        $key = '$_gkn_navi_key'.$id;

        if (isset($args['key'])) {
            $key = $args['key'];
        }

        $code = "
if ($total > 0) {
    if ($now > $total) {
        $now = $total;
    }
    if ($now < 0) {
        $now = 1;
    }
    $from = $now - $frame;
    $till = $now + $frame;
    if ($from < 1) {
        $till -= $from - 1;
        $from = 1;
    }
    if ($till > $total) {
        $from -= $till - $total;
        $till = $total;
    }
    if ($from < 1) {
        $from = 1;
    }
    for ($key = $from; $key <= $till; $key++) {
        if ($key != $now) {
";

       return $code . $compiler->compile_str($this->content_raw, $this) . "}}}\n";
    }
}
