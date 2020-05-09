<?php

namespace Reactor\Forms;

use \Reactor\WebComponents\MethodController;

class FormController extends MethodController {

    public function __construct($form_yml, $handler) {
        $this->form_yml = $form_yml;
        $this->handler = $handler;
    }

    public function createForm() {
        return $this->app->web->form->buildFromYML($this->app, $this->form_yml);
    }

    public function onGET($req_res) {
        return $this->createForm();
    }

    public function onPOST($req_res) {
        $form = $this->createForm();
        $form->setData($req_res->request->post, 'fromForm');
        $form->validate();
        if ($form->isErrors()) {
            return $form;
        }
        $this->app->callService($this->handler[0], $this->handler[1], $form->getData());
        $req_res->location($this->app->web->url->build(array('done' => 1)));
        return null;
    }

}
