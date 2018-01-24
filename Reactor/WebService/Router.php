<?php

namespace Reactor\WebService;

class Router {

    function routeRequest($request, $tree) {
        $context = new RouterContext($this->normalizePath($request->path));
        $request->metadata['route'] = $this->route($context, $tree);
    }

    function route($rez, $tree) {
        $tree_pointer = &$tree;
        $cnt = count($rez->path);
        $this->applyNode($rez, $tree_pointer);
        while ($rez->cursor < $cnt) {
            $step = $rez->path[$rez->cursor];
            if (isset($tree_pointer['nodes'][$step])) {
                $tree_pointer = &$tree_pointer['nodes'][$step];
            } else {
                if (isset($tree_pointer['nodes']['{variable}'])) {
                    $tree_pointer = &$tree_pointer['nodes'][$step];
                } else {
                    return $rez->apply404();
                }
            }
            $this->applyNode($rez, $tree_pointer);
            $rez->cursor++;
        }
        return $rez;
    }

    function applyNode($rez, $node) {
        if (isset($node['name'])) {
            $rez->variables[$node['name']] = $rez->path[$rez->cursor];
        }
        if (isset($node['router'])) {
            $this->getRouter($node['router'])->route($rez, $node);
        }
        if (isset($node['nodes']['404'])) {
            $rez->not_found_node = $node['nodes']['404'];
        }
        if (!isset($node['inherit'])) {
            unset($node['nodes']);
            $rez->node = $node;
            $rez->nodes[] = $node;
        }
    }

    function getRouter($router) {
        if (class_exists($router)) {
            return new $router();
        }
        return $name;
    }

    function normalizePath($path) {
        $path = trim($path, '/');
        if ($path == '') {
            $path = array();
        } else {
            $path = explode('/', $path);
        }
        return $path;
    }

}
