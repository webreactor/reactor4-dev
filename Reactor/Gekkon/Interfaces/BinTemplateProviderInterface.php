<?php

namespace Reactor\Gekkon\Interfaces;

interface BinTemplateProviderInterface {

    public function save($template, $bin_tpl_code);
    public function load($template);
    public function clear_cache($template);

}
