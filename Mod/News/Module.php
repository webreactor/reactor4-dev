<?php

namespace Mod\News;

use Reactor\ServiceContainer\Reference;

class Module extends \Reactor\Application\Module {

    public function onLoad() {
        $this['dispatcher']->addListener('#', array($this->getReference('printer'), 'display'));
    }

    public function init() {
        $this->setSecure('printer', new Printer());
    }

}
