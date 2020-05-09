<?php

namespace Reactor\Forms;

use \Reactor\Application\MultiService;

class FormStrategy {

    public $fields;
    public $error_url;
    public $success_url;
    public $cancel_url;
    public $data;
    public $handler;

    public function __construct() {
    }

}
