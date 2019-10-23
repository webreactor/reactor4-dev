<?php

namespace Mod\News;

use \Reactor\Generic\Model\CollectionModel;
use \Reactor\ContentAdapter\FormController2;

class Module extends \Reactor\Application\Module {

    public function onLoad() {
        //$this['events']->addListener('#', array($this->getReference('printer'), 'display'));
    }

    public function onUse() {
        $this->collection = new CollectionModel($this->db, 'news_data', 'pk_news');
        $this->printer = new Printer();
        $this->form = new FormController2('form.yml', array('/news/printer', 'display'));
    }

}
