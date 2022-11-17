<?php

use App\Domains\ShortUrls\Http\Controllers\Frontend\ShortUrlsController;

/*
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.shorturls'.
 */
Route::group([
    'prefix' => 's',
    'as' => 'shorturls.',
], function () {
    Route::get('{shortUrls:keyword}', [ShortUrlsController::class, 'index'])
        ->name('index');
});
