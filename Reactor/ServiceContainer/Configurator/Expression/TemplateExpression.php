<?php

namespace Reactor\ServiceContainer\Configurator\Expression;

use Reactor\ServiceContainer\ServiceProvider;

// =config_{@dev}.yml

class TemplateExpression extends PrefixedExpression {

    protected $exp_manager;

    public function __construct($exp_manager) {
        $this->exp_manager = $exp_manager;
        $this->token = '=';
    }

    public function compileLogic($value) {
        $parsed = $this->parse($value);
        $is_provider = false;
        foreach ($parsed as $key => $value) {
            if ($value['type'] == 'static') {
                $parsed[$key] = $value['value'];
            } else {
                $is_provider = true;
                $parsed[$key] = $this->exp_manager->compile($value['value']);
            }
        }
        if ($is_provider) {
            if (count($parsed) == 1) {
                return current($parsed);
            }
            return new ServiceProvider('implode', array($parsed));
        }

        return implode($parsed);
    }

    protected function parse($value) {
        $matches = array();
        $rez = array();
        if (!preg_match_all('/(?<!\\\\)(\\{.+(?<!\\\\)\\})/Uu', $value, $matches, PREG_OFFSET_CAPTURE)) {
            $rez[] =  array('type'=>'static', 'value' => $value);
        } else {
            $current = 0;
            foreach ($matches[1] as $match) {
                $len = strlen($match[0]);
                $start = $match[1];
                if ($current != $start) {
                    $rez[] = array('type'=>'static', 'value' => substr($value, $current, $start - $current));
                }
                $rez[] = array('type'=>'expression', 'value' => substr($value, $start + 1, $len - 2));
                $current = $start + $len;
            }
            if ($current != strlen($value)) {
                $rez[] = array('type'=>'static', 'value' => substr($value, $current));    
            }
        }
        foreach ($rez as $key => $value) {
            $rez[$key]['value'] = str_replace(['\{', '\}'], ['{', '}'], $value['value']);
        }
        return $rez;
    }

}