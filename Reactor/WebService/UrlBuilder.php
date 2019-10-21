<?php

namespace Reactor\WebService;

use Reactor\Application\MultiService;

class UrlBuilder extends MultiService {

    protected $templates = null;
    protected $used_vars = array();

    public function build($variables = array()) {
        $rr = $this->app->get('req_res');
        $data = $variables + $rr->route->variables + $rr->request->get;
        $cache_key = implode('_', array_keys($data));
        if (!isset($this->templates[$cache_key])) {
            $this->templates[$cache_key] = $this->buildUrlTemplate($data, $rr);
        }
        $cache = $this->templates[$cache_key];
        return $this->fillUrlTemplate($cache[0], $data, $cache[1]);
    }

    public function fillUrlTemplate($template, $data, $url_vars) {
        $replace = array();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                array_walk($value, 'rawurlencode');
                $replace["#$key#"] = implode('/',  $value);
            } else {
                $replace["#$key#"] = rawurlencode($value);
            }
        }
        $link = strtr($template, $replace);
        $get = array();
        foreach ($data as $key => $value) {
            if (!in_array($key, $url_vars)) {
                $get[$key] = $value;
            }
        }
        if (count($get) > 0) {
            ksort($get);
            $link .= '?'.http_build_query($get);
        }
        return $link;
    }

    public function buildUrlTemplate($data, $rr) {
        $template = '/';
        $node = $this->app->get('site_tree');
        $this->used_vars = array();
        foreach ($rr->route->steps as $step) {
            if (isset($step['node_key'])) {
                $node = $node['nodes'][$step['node_key']];
                $template .= $this->getStep($step['node_key'], $node, $data);
            }
        }
        while (isset($node['nodes']) && isset($node['nodes']['$any'])) {
            $node = $node['nodes']['$any'];
            $template .= $this->getStep('$any', $node, $data);
        }
        return array($template, $this->used_vars);
    }

    protected function getStep($key, $node, $data) {
        $step = '';
        if (isset($node['variable'])) {
            $name = $node['variable'];
            if (isset($data[$name])) {
                $this->used_vars[] = $name;
                $step = "#$name#/";
            }
        } else {
            if ($key != '$any') {
                $step = $key.'/';
            }
        }
        return $step;
    }

}
