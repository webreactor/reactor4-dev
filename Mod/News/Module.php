<?php

namespace Mod\News;

use Reactor\ServiceContainer\Reference;

class Module extends \Reactor\Application\Module {

    public function init() {
        $this->set('printer', new Printer());
    }

    public function onLoad() {
        $this['dispatcher']->addListener('#', array($this->getReference('printer'), 'display'));
    }

}
