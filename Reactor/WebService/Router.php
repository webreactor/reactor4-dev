<?php

namespace Reactor\WebService;

// implements HTTPRouterInterface
class Router {

    public function __construct($application, $config) {
        $this->application = $application;
        $this->config = $config;
    }

    public function handleRequest($request_responce) {
        echo "<pre>".print_r($this->config, true)."</pre>";
        $rez = $this->parseUrl($request_responce->request->uri());
        echo "<pre>".print_r($rez, true)."</pre>";
    }

    public function parseUrl($url) {
        $url_words = explode('/', 'root'.$url);
        $tree = $this->config;
        $path = array();
        $variables = array();
        foreach ($url_words as $word) {
            echo "Word: $word<br>";
            $assign = $word;
            if (!isset($tree[$word])) {
                $word = '_default';
            } 
            if (!isset($tree[$word])) {
                return 'fault';
            }
            $tree = $tree[$word];
            
            if (isset($tree['_node']['variable'])) {
                $word = $tree['_node']['variable'];
                $variables[$word] = $assign;
            }
            $path[$word] = $tree['_node'];
        }
        echo "<pre>".print_r($variables, true)."</pre>";
        echo "<pre>".print_r($path, true)."</pre>";
        
    }


}
