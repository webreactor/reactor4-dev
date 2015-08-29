<?php

namespace Reactor\ServiceContainer;

class Reference implements ServiceProviderInterface {

    protected $name;
    protected $loading = false;

    public function __construct($name = array()) {
        if (!is_array($name)) {
            $name = explode('/', trim($name, '/'));
        }
        $this->name = $name;
    }

    public function getService($container = null) {
        if ($this->loading) {
            throw new Exceptions\CircularReferenceExeption(implode('/', $this->name));
        }
        $this->loading = true;
        $val = $container;

        $cnt = count($this->name);
        for ($i = 0; $i < $cnt; $i++) {
            $val = $val[$this->name[$i]];
        }

        $this->loading = false;
        return $val;
    }

    public function reset() {}

}
