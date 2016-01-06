<?php

namespace Reactor\WebService;

// implements HTTPRouterInterface
class Router implements RouterInterface {

    public function __construct($application, $config) {
        $this->application = $application;
        $this->config = $config;
    }

    public function route($request_responce) {
        echo "<pre>".print_r($this->config, true)."</pre>";
        $request = $request_responce->request;
        
        return $this->parseUrl($request_responce);
    }

    public function parseUrl($request_responce) {
        $request = $request_responce->request;
        $url = parse_url($request->uri());
        $task = $request->metadata['render_task'];
        $path_words = explode('/', rtrim('root'.$url['path'], '/'));
        $tree = $this->config;
        while ($word = array_shift($path_words)) {
            $assign = $word;
            if (!isset($tree[$word])) {
                $word = '_default';
            } 
            if (!isset($tree[$word])) {
                $path_step = $this->config['404'];
            } else {
                $tree = $tree[$word];
                $path_step = $tree['_node'];   
            }
            
            if (isset($path_step['variable'])) {
                $word = $path_step['variable'];
                $request_responce->request->query[$word] = $assign;
            }

            if (isset($path_step['router'])) {
                $url['path'] = '/'.implode('/', $path_words);
                $request->setUri($this->buildUrl($url));
                return $this->application->get($path_step['router']);
            }

            $path_step['name'] = $word;
            $task->registerStep($path_step);    
        }
        return true;
    }

    public function buildUrl($parts) {
        $rez = $parts['path'];
        if (isset($parts['query'])) {
            $rez .= '?'.$parts['query'];
        }
        return $rez;
    }

}
