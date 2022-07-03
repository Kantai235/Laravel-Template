<?php

use App\Http\Controllers\LocaleController;

// All route names are prefixed with 'api.'.
Route::get('lang/{lang}.json', [LocaleController::class, 'content'])
    ->name('locale.content');
