<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Tools extends MultiService {

    public function makeUrlTemplate($data) {
        $link = '/';
        $rr = $this->app['req_res'];
        $node = $this->app['site_tree'];
        $variables = $data + $rr->route->variables;
        foreach ($rr->route->steps as $step) {
            if (isset($step['node_key'])) {
                $node = $node['nodes'][$step['node_key']];
                $link .= $this->getStep($step['node_key'], $node, $variables);
            }
        }
        while (isset($node['nodes']) && isset($node['nodes']['$any'])) {
            $node = $node['nodes']['$any'];
            $link .= $this->getStep('$any', $node, $variables);
        }
        return $link;
    }

    protected function getStep($key, $node, $variables) {
        $step = '';
        if (isset($node['variable']) && isset($variables[$node['variable']])) {
            if (is_array($variables[$node['variable']])) {
                $step = implode('/', $variables[$node['variable']]).'/';
            } else {
                $step = $variables[$node['variable']].'/';
            }
        } else {
            if ($key != '$any') {
                $step = $key.'/';
            }
        }
        return $step;
    }

}
