<?php

use Carbon\Carbon;

if (! function_exists('setAllLocale')) {
    function setAllLocale(string $locale): void
    {
        setAppLocale($locale);
        setPHPLocale($locale);
        setCarbonLocale($locale);
        setLocaleReadingDirection($locale);
    }
}

if (! function_exists('setAppLocale')) {
    function setAppLocale(string $locale): void
    {
        app()->setLocale($locale);
    }
}

if (! function_exists('setPHPLocale')) {
    function setPHPLocale(string $locale): void
    {
        setlocale(LC_TIME, $locale);
    }
}

if (! function_exists('setCarbonLocale')) {
    function setCarbonLocale(string $locale): void
    {
        Carbon::setLocale($locale);
    }
}

if (! function_exists('setLocaleReadingDirection')) {
    function setLocaleReadingDirection(string $locale): void
    {
        /*
         * Set the session variable for whether or not the app is using RTL support
         * For use in the blade directive in BladeServiceProvider
         */
        if (! app()->runningInConsole()) {
            if (config('template.locale.languages')[$locale]['rtl']) {
                session([
                    'lang-rtl' => true,
                ]);
            } else {
                session()->forget('lang-rtl');
            }
        }
    }
}

if (! function_exists('getLocaleName')) {
    function getLocaleName(string $locale): string
    {
        return config('template.locale.languages')[$locale]['name'];
    }
}
