<?php

namespace Reactor\WebService;

// implements HTTPRouterInterface
class StandardRouter implements RouterInterface {

    public function __construct($application, $site_tree) {
        $this->application = $application;
        $this->site_tree = $site_tree;
    }

    public function route($request_responce) {
        if (isset($request->request->meta_data['router_context'])) {
            $context = $request->request->meta_data['router_context'];
        } else {
            $context = $this->createContext($path, $request_responce);
        }
        return $this->parseUrl($context);
    }

    public function createContext($path, $request_responce) {
        $request = $request_responce->request;
        $context = new StandardRouterContext();
        $context->request = $request;
        $context->words = explode('/', rtrim('root'.$request->link->path, '/'));
        $context->site_tree = $this->site_tree;
        $context->task = $request->metadata['render_task'];
        return $context;
    }

    public function parseUrl($context) {
        while (($word = array_shift($context->words)) !== null) {
            $this->parseStep($word, $context);
            $this->assignVariable($word, $context);
            $router = $this->getRouter($word, $context);
            if ($router !== false) {
                return $router;
            }
        }
        return true;
    }

    public function parseStep($word, $context) {
        if (!isset($context->site_tree[$word])) {
            $word = '_default';
        }
        if (!isset($context->site_tree[$word])) {
            $context->step = $this->site_tree['404'];
        } else {
            $context->site_tree = $context->site_tree[$word];
            $context->step = $context->site_tree['_node'];
        }
        $context->step['name'] = $word;
        $context->task->registerStep($context->step);
    }

    public function assignVariable($word, $context) {
        if (isset($context->step['variable'])) {
            $key = $context->step['variable'];

            if (empty($context->step['greedy'])) {
                $context->request->get[$key] = $word;
            } else {
                $context->request->get[$key] = array_merge([$word], $context->words);
                $context->words = array();
            }

            $context->assigned = true;
        }
    }

    public function getRouter($word, $context) {
        if (isset($context->step['router'])) {
            if ($context->assigned) {
                $context->request->link->path = '/'.implode('/', $context->words);    
            } else {
                $context->request->link->path = '/'.$word.'/'.implode('/', $context->words);    
            }
            return $this->application->getByPath($context->step['router']);
        }
        return false;
    }

}
