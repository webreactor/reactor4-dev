<?php

namespace Reactor\Gekkon;

class DefaultSettings {

    static function get() {
        return array(
            'display_errors' => true,
            'auto_escape' => false,
            'force_compile' => false,
            'tag_systems' => array(
                'SimpleEcho' => array(
                    'open' => '{',
                    'close' => '}',
                ),
                'Common' => array(
                    'open' => '{',
                    'close' => '}',
                ),
                'Gettext' => array(
                    'open' => '{{',
                    'close' => '}}',
                ),
                'Comment' => array(
                    'open' => '{#',
                    'close' => '#}',
                ),
            ),
        );
    }

}
