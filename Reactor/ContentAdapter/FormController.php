<?php

namespace Reactor\ContentAdapter;

use \Reactor\Application\MultiService;

class FormController extends MultiService {

    public function __construct($form_yml, $handler) {
        $this->form_yml = $form_yml;
        $this->handler = $handler;
    }

    public function handle($req_res) {
        if ($req_res->request->method === 'POST') {
            return $this->handleForm($req_res);
        }
        if ($req_res->request->method === 'GET') {
            return $this->renderForm($req_res);
        }
    }

    public function createForm() {
        return $this->app->web->form->buildFromYML($this->app, $this->form_yml);

    }

    public function renderForm($req_res) {
        return $this->createForm();
    }

    public function handleForm($req_res) {
        $form = $this->createForm();
        $form->setData($req_res->request->post, 'fromForm');
        $form->validate();
        if ($form->isErrors()) {
            return $form;
        } else {
            $this->app->callService($this->handler[0], $this->handler[1], $form->getData());
            $req_res->response->location($this->app->web->url->build(array('done' => 1)));
        }
        unset($req_res->route->target['template']);
        // print_r($req_res->response);die();
    }

}
