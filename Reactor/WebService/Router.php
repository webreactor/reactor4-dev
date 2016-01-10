<?php

namespace Reactor\WebService;

// implements HTTPRouterInterface
class Router implements RouterInterface {

    public function __construct($application, $config) {
        $this->application = $application;
        $this->config = $config;
    }

    public function route($request_responce) {
        $request = $request_responce->request;
        $path_words = explode('/', rtrim('root'.$request->link->path, '/'));
        $tree = $this->config;
        $task = $request->metadata['render_task'];
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
                $request->get[$word] = $assign;
            }

            if (isset($path_step['variable_path'])) {
                $word = $path_step['variable_path'];
                $assign = array_merge([$assign], $path_words);
                $path_words = array();
                $request->get[$word] = $assign;
            }

            $path_step['name'] = $word;
            $task->registerStep($path_step);

            if (isset($path_step['router'])) {
                $request->link->path = '/'.implode('/', $path_words);
                return $this->application->get($path_step['router']);
            }
        }
        return true;
    }

}
