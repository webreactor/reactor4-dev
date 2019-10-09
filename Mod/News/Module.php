<?php

namespace Mod\News;

use Reactor\Generic\Model\CollectionModel;

class Module extends \Reactor\Application\Module {

    public function onLoad() {
        //$this['events']->addListener('#', array($this->getReference('printer'), 'display'));
    }

    public function onUse() {
        $this->collection = new CollectionModel($this->get('db'),'news_data', 'pk_news');
        $this->printer = new Printer();
    }

}
