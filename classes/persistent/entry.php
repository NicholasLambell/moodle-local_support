<?php

namespace local_support\persistent;

use core\persistent;

class entry extends persistent {

    const TABLE = 'local_support_entries';

    /**
     * Define persistent properties.
     *
     * @return array Properties.
     */
    protected static function define_properties(): array {
        global $USER;

        return [
            'name' => [
                'type' => PARAM_TEXT,
                'default' => fullname($USER),
            ],
            'date' => [
                'type' => PARAM_INT,
            ],
            'site' => [
                'type' => PARAM_INT,
                'null' => NULL_ALLOWED,
                'default' => null,
            ],
            'emaillevel1' => [
                'type' => PARAM_INT,
            ],
            'emaillevel2' => [
                'type' => PARAM_INT,
            ],
            'emaillevel3' => [
                'type' => PARAM_INT,
            ],
            'emaillevel4' => [
                'type' => PARAM_INT,
            ],
            'phonelevel1' => [
                'type' => PARAM_INT,
            ],
            'phonelevel2' => [
                'type' => PARAM_INT,
            ],
            'phonelevel3' => [
                'type' => PARAM_INT,
            ],
            'phonelevel4' => [
                'type' => PARAM_INT,
            ],
        ];
    }
}