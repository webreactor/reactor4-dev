<?php

namespace Reactor\WebService;

// implements HTTPRouterInterface
class StandardRouter implements RouterInterface {

    public function __construct($application, $site_tree) {
        $this->application = $application;
        $this->site_tree = $site_tree;
    }

    public function route($request_responce) {
        $request = $request_responce->request;
        if (!isset($request->meta_data['router_context'])) {
            $request->meta_data['router_context'] = $this->createContext($request);
        }
        return $this->parseUrl($request->meta_data['router_context']);
    }

    public function createContext($request) {
        $words = explode('/', rtrim('root'.$request->link->path, '/'));
        return new StandardRouterContext($words);
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
        }
    }

    public function getRouter($word, $context) {
        if (isset($context->step['router'])) {
            if ($context->step['variable']) {
                $context->request->link->path = '/'.implode('/', $context->words);    
            } else {
                $context->request->link->path = '/'.$word.'/'.implode('/', $context->words);    
            }
            return $this->application->getByPath($context->step['router']);
        }
        return false;
    }

}
