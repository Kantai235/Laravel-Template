<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Lang;

/**
 * Class LocaleController.
 */
class LocaleController
{
    /**
     * @param  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change($locale)
    {
        app()->setLocale($locale);

        session()->put('locale', $locale);

        return redirect()->back();
    }

    /**
     * @param  $locale
     * @return \Illuminate\Http\JsonResponse
     */
    public function content($locale)
    {
        if (array_key_exists($locale, config('template.locale.languages'))) {
            $content = Lang::get('plugins', [], $locale);

            return response()->json($content);
        }

        return response()->json([
            'message' => __('Unknown language.'),
        ], 404);
    }
}
