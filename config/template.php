<?php

/*
 * All configuration options for Laravel Template at:
 * https://github.com/Kantai235/Laravel-Template/
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    |
    | Found in views/includes/partials/ga.blade.php
    */
    'google_analytics' => env('GOOGLE_ANALYTICS', 'UA-XXXXX-X'),

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | Configurations related to the template's locale system
    */
    'locale' => [
        /*
         * Whether or not to show the language picker, or just default to the default
         * locale specified in the app config file
         */
        'status' => true,

        /*
         * Available languages
         *
         * Add your language code to this array.
         * The code must have the same name as the language folder.
         * Be sure to add the new language in an alphabetical order.
         *
         * The language picker will not be available if there is only one language option
         * Commenting out languages will make them unavailable to the user
         */
        'languages' => [
            'zh' => ['name' => '简体中文', 'rtl' => false],
            'zh-TW' => ['name' => '繁體中文', 'rtl' => false],
            'en' => ['name' => 'English', 'rtl' => false],
        ],
    ],
];
