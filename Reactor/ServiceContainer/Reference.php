<?php

namespace Reactor\ServiceContainer;

class Reference implements ServiceProviderInterface {

    protected $name;
    protected $loading = false;

    public function __construct($name = array()) {
        if (!is_array($name)) {
            if ($name[0] == '/') {
                $name = '__root__'.$name;
            }
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
            if ($i == 0 && $this->name[0] == '__root__') {
                $val = $val->getRoot();
            } else {
                $val = $val->get($this->name[$i]);
            }
        }

        $this->loading = false;
        return $val;
    }

}
