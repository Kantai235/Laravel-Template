<?php

use JamesMills\LaravelTimezone\Timezone;

if (!function_exists('timezone')) {
    /**
     * Access the timezone helper.
     */
    function timezone(): mixed
    {
        return resolve(Timezone::class);
    }
}
