<?php

if (!function_exists('activeClass')) {
    /**
     * Get the active class if the condition is not falsy.
     */
    function activeClass(
        bool $condition,
        string $activeClass = 'active',
        string $inactiveClass = ''
    ): string {
        return $condition
            ? $activeClass
            : $inactiveClass;
    }
}

if (!function_exists('htmlLang')) {
    /**
     * Access the htmlLang helper.
     */
    function htmlLang(): string|array
    {
        return str_replace('_', '-', app()->getLocale());
    }
}
