<?php

namespace Mod\News;

use Reactor\ServiceContainer\Reference;

class Module extends \Reactor\Application\Module {

    public function onLoad() {
        //$this['events']->addListener('#', array($this->getReference('printer'), 'display'));
    }

    public function onUse() {
        $this->set('printer', new Printer());
    }

}
