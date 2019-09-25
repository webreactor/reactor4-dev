<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class Router extends MultiService {

    public function routeRequest($req_res) {
        $this->route($req_res, $this->app['site_tree']);
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
            } elseif (isset($tree_pointer['nodes']['$any'])) {
                $tree_pointer = &$tree_pointer['nodes']['$any'];
            } else {
                $route->switchToError();
                $req_res->response->code = 404;
                break;
            }
            $this->applyNode($route, $tree_pointer);
            $route->cursor++;
            if (isset($tree_pointer['final'])) {
                break;
            }
        }
    }

    public function applyNode($route, $node) {
        if (isset($node['variable'])) {
            $route->variables[$node['variable']] = $route->path[$route->cursor];
        }
        if (isset($node['$error'])) {
            $route->error_handlers[] = $node['$error'];
        }
        unset($node['nodes']);
        $route->target = $node;
        $route->steps[] = $node;
    }

}
