<?php

namespace Reactor\WebService;

class Module extends \Reactor\Application\Module {

    public function initDefaults() {
        $this->set('router', function () { return new Router(); });
        $this->set('controller_manager', function ($container) { return new ControllerManager($container->getRoot()); });
        $this->setCached('global_request_response', function ($container) {
            return new RequestResponse(RequestFactory::buildFromGlobals(), new Response());
        });
        $this->set('core', function ($container) {
            $core = new Core();
            $core->router = $container['router'];
            $core->controller_manager = $container['controller_manager'];
            $core->dispatcher = $container['dispatcher'];
            $core->tree = $container['tree'];
            return $core;
        });
    }

    public function handleGlobalRequest() {
        $this['core']->handleRequest($this['global_request_response']);
    }

    public function execute($service = null, $method = null, $arguments = [], $module = null, $template = null, $template_arguments = []) {

        $template_arguments = array(
            'service' => $service,
            'method' => $method,
            'arguments' => $arguments,
        );

        $result = null;
        if ($service !== null) {
            $result = $this['application']->getByPath($service);
            if ($method !== null) {
                $result = call_user_func_array(array($result,$method), $arguments);
            }
        }

        $template_arguments['data'] = $result;

        if ($template !== null) {
            $this->view->display($template, $template_arguments, $module);
        }

        return $result;
    }

}
