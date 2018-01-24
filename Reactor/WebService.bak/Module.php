<?php

namespace Reactor\WebService;

class Module extends \Reactor\Application\Module {

    public function handleGlobalRequest() {
        $this->core->handleRequest($this->request_factory->buildFromGlobals());
    }

    public function execute($service = null, $method = null, $arguments = [], $module = null, $template = null, $template_arguments = []) {

        $template_arguments = array(
            'service' => $service,
            'method' => $method,
            'arguments' => $arguments
        );

        $result = null;
        if ($service !== null) {
            $result = $this->application->getByPath($service);
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
