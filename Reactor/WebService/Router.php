<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Router extends MultiService {

    public function routeRequest($req_res) {
        $this->route($req_res->route, $this->app['site_tree']);
        if ($req_res->route->not_found) {
            $req_res->response->code = 404;
        }
    }

    public function route($route, $tree) {
        $tree_pointer = &$tree;
        $cnt = count($route->path);
        $this->applyNode($route, $tree_pointer);
        while ($route->cursor < $cnt) {
            $step = $route->path[$route->cursor];
            if (isset($tree_pointer['nodes'][$step])) {
                $tree_pointer = &$tree_pointer['nodes'][$step];
            } else {
                if (isset($tree_pointer['nodes']['$any'])) {
                    $tree_pointer = &$tree_pointer['nodes']['$any'];
                } else {
                    $this->apply404($route);
                    break;
                }
            }
            $route->cursor++;
            $this->applyNode($route, $tree_pointer);
            if (isset($tree_pointer['final'])) {
                break;
            }
        }
    }

    public function applyNode($route, $node) {
        if (isset($node['variable'])) {
            $route->variables[$node['variable']] = $route->path[$route->cursor];
        }
        if (isset($node['nodes']['404'])) {
            $route->not_found_node = $node['nodes']['404'];
        }
        unset($node['nodes']);
        $route->target = $node;
        $route->steps[] = $node;
    }

    public function apply404($route) {
        $route->target = $route->not_found_node;
        $route->not_found = true;
    }

}
