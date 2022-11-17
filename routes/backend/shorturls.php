<?php

use App\Domains\ShortUrls\Http\Controllers\Backend\ShortUrlsController;
use App\Domains\ShortUrls\Http\Controllers\Backend\DeactivatedShortUrlsController;
use App\Domains\ShortUrls\Http\Controllers\Backend\DeletedShortUrlsController;
use App\Domains\ShortUrls\Models\ShortUrls;
use Tabuna\Breadcrumbs\Trail;

/**
 * All route names are prefixed with 'admin.shorturls'.
 */
Route::group([
    'prefix' => 'shorturls',
    'as' => 'shorturls.',
    'middleware' => config('template.access.middleware.confirm'),
], function () {
    Route::group([
        'middleware' => 'role:' . config('template.access.role.shorturls'),
    ], function () {
        Route::get('deleted', [DeletedShortUrlsController::class, 'index'])
            ->name('deleted')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.shorturls.index')
                    ->push(
                        __('Deleted Short Urls'),
                        route('admin.shorturls.deleted')
                    );
            });

        Route::get('create', [ShortUrlsController::class, 'create'])
            ->name('create')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.shorturls.index')
                    ->push(
                        __('Create Short Urls'),
                        route('admin.shorturls.create')
                    );
            });

        Route::post('/', [ShortUrlsController::class, 'store'])
            ->name('store');

        Route::group([
            'prefix' => '{shorturls}',
        ], function () {
            Route::get('edit', [ShortUrlsController::class, 'edit'])
                ->name('edit')
                ->breadcrumbs(function (Trail $trail, ShortUrls $shorturls) {
                    $trail->parent('admin.shorturls.index', $shorturls)
                        ->push(
                            __('Edit'),
                            route('admin.shorturls.edit', $shorturls)
                        );
                });

            Route::patch('/', [ShortUrlsController::class, 'update'])
                ->name('update');
            Route::delete('/', [ShortUrlsController::class, 'destroy'])
                ->name('destroy');
        });

        Route::group([
            'prefix' => '{deletedShortUrls}',
        ], function () {
            Route::patch('restore', [DeletedShortUrlsController::class, 'update'])
                ->name('restore');
            Route::delete('permanently-delete', [DeletedShortUrlsController::class, 'destroy'])
                ->name('permanently-delete');
        });
    });

    Route::group([
        'middleware' => 'permission:' . implode('|', [
            'admin.shorturls.list',
            'admin.shorturls.deactivate',
            'admin.shorturls.reactivate',
        ]),
    ], function () {
        Route::get('deactivated', [DeactivatedShortUrlsController::class, 'index'])
            ->name('deactivated')
            ->middleware('permission:' . implode('|', [
                'admin.shorturls.reactivate',
            ]))
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.shorturls.index')
                    ->push(
                        __('Deactivated shorturlss'),
                        route('admin.shorturls.deactivated')
                    );
            });

        Route::get('/', [ShortUrlsController::class, 'index'])
            ->name('index')
            ->middleware('permission:' . implode('|', [
                'admin.shorturls.list',
                'admin.shorturls.deactivate',
            ]))
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(
                        __('Short Urls Management'),
                        route('admin.shorturls.index')
                    );
            });

        Route::group([
            'prefix' => '{shorturls}',
        ], function () {
            Route::get('/', [ShortUrlsController::class, 'show'])
                ->name('show')
                ->middleware('permission:' . implode('|', [
                    'admin.shorturls.list',
                ]))
                ->breadcrumbs(function (Trail $trail, ShortUrls $shorturls) {
                    $trail->parent('admin.shorturls.index')
                        ->push(
                            $shorturls->message,
                            route('admin.shorturls.show', $shorturls)
                        );
                });

            Route::patch('mark/{status}', [DeactivatedShortUrlsController::class, 'update'])
                ->name('mark')
                ->where(['status' => '[0,1]'])
                ->middleware('permission:' . implode('|', [
                    'admin.shorturls.deactivate',
                    'admin.shorturls.reactivate',
                ]));
        });
    });
});
