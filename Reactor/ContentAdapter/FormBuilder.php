<?php

namespace Reactor\ContentAdapter;

use \Reactor\Application\Multiservice;

class FormBuilder extends MultiService {

    public function build($config, $module) {
        $form = new Form();
        foreach ($config['fields'] as $name => $define) {
            $field = new $define['type']($define);
            $field = $module->resolveService($field);
            $field->validator = $this->buildValidator($define, $module);
            $form->fields[$name] = $field;
        }
        return $form;
    }

    public function buildFromYML($module, $path) {
        $module = $this->app->resolveService($module);
        $config = $this->app->yml->load($module->getDir().$path);
        return $this->build($config, $module);
    }

    public function buildValidator($define, $module) {
        $validator_class = '\\Reactor\\ContentAdapter\\ValidationManager';
        if (isset($define['validator'])) {
            $validator_class = $define['validator'];
        }
        $manager = new $validator_class($define);
        if ($manager instanceof ValidationManager && isset($define['validators'])) {
            $validators = array();
            foreach ($define['validators'] as $key => $validator_def) {
                $validator = $validator_def[0];
                if (is_array($validator)) {
                    $validator[0] = $module->getByPath($validator[0]);
                } elseif ($validator[0] != '\\') {
                    $validator = '\\Reactor\\ContentAdapter\\BasicValidator::'.$validator;
                }
                $validators[] = $validator;
            }
            $manager->validators = $validators;
        }
        return $manager;
    }

}
