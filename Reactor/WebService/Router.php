<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Router extends MultiService {

    public function routeRequest($req_res) {
        $this->route($req_res, $this->app->get('site_tree'));
    }

    public function route($req_res, $tree) {
        $route = $req_res->route;
        $tree_pointer = &$tree;
        $cnt = count($route->path);
        $this->applyNode($route, $tree_pointer);
        while ($route->cursor < $cnt) {
            $step = $route->path[$route->cursor];
            if (isset($tree_pointer['nodes'][$step])) {
                $tree_pointer = &$tree_pointer['nodes'][$step];
                $tree_pointer['node_key'] = $step;
            } elseif (isset($tree_pointer['nodes']['$any'])) {
                $tree_pointer = &$tree_pointer['nodes']['$any'];
                $tree_pointer['node_key'] = '$any';
            } else {
                throw new PageNotFoundException('At routing');
            }
            $this->applyNode($route, $tree_pointer);
            $route->cursor++;
            if (isset($tree_pointer['final'])) {
                $route->cursor = $cnt;
            }
        }
    }

    public function applyNode($route, $node) {
        if (isset($node['variable'])) {
            if (isset($node['final'])) {
                $route->variables[$node['variable']] = array_slice($route->path, $route->cursor);
            } else {
                $route->variables[$node['variable']] = $route->path[$route->cursor];
            }
        }
        if (isset($node['error'])) {
            $route->error_handlers[] = $node['error'];
        }
        unset($node['nodes']);
        $route->target = $node;
        $route->steps[] = $node;
    }

}
