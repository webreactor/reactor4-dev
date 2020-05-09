<?php

namespace Reactor\Forms;

use \Reactor\Application\MultiService;

class FormController2 extends MultiService {

    public function __construct($form_yml, $handler) {
        $this->form_yml = $form_yml;
        $this->handler = $handler;
    }

    public function onUse() {
        $this->web = $this->app->web;
    }

    public function handle($req_res) {
        if ($req_res->request->method === 'POST') {
            return $this->handleForm($req_res);
        }
        if ($req_res->request->method === 'GET') {
            return $this->renderForm($req_res);
        }
    }

    public function createForm($req_res) {
        $form = $this->web->form->buildFromYML($this->app, $this->form_yml);
        $token = $req_res->getVariable('so', 'isString', null);
        if ($token !== null) {
            $forms = $this->web->session->getCollection('forms');
            if (isset($forms[$token]) && isset($forms[$token]['settings'])) {
                $form->setState($forms[$token]);
            }
        }
        return $form;
    }

    public function renderForm($req_res) {
        return $this->createForm($req_res);
    }

    public function handleForm($req_res) {
        $form = $this->createForm($req_res);
        $form->setData($req_res->request->post, 'fromForm');
        $form->validate();
        if ($form->isErrors()) {
            $forms = $this->web->session->getCollection('forms');
            if (!isset($forms->settings['so'])) {
                $forms->settings['so'] = uniqid('', true);
            }
            $form_so = $forms->settings['so'];
            $forms[$form_so] = $form->getState();
            $req_res->location($this->web->url->build($req_res, array('so' => $form_so)));   
        } else {
            $this->app->callService($this->handler[0], $this->handler[1], $form->getData());
            $req_res->location($this->web->url->build($req_res, array('done' => 1)));            
        }
        return null;
    }

}
