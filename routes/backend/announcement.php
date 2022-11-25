<?php

use App\Domains\Announcement\Http\Controllers\Backend\AnnouncementController;
use App\Domains\Announcement\Http\Controllers\Backend\DeactivatedAnnouncementController;
use App\Domains\Announcement\Http\Controllers\Backend\DeletedAnnouncementController;
use App\Domains\Announcement\Models\Announcement;
use Tabuna\Breadcrumbs\Trail;

/**
 * All route names are prefixed with 'admin.announcement'.
 */
Route::group([
    'prefix' => 'announcement',
    'as' => 'announcement.',
    'middleware' => [
        config('template.access.middleware.confirm'),
        'permission:admin.announcement.list',
    ],
], function () {
    Route::get('deleted', [DeletedAnnouncementController::class, 'index'])
        ->name('deleted')
        ->middleware('permission:admin.announcement.destore')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.announcement.index')
                ->push(
                    __('Deleted Announcements'),
                    route('admin.announcement.deleted')
                );
        });

    Route::get('create', [AnnouncementController::class, 'create'])
        ->name('create')
        ->middleware('permission:admin.announcement.edit')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.announcement.index')
                ->push(
                    __('Create Announcement'),
                    route('admin.announcement.create')
                );
        });

    Route::post('/', [AnnouncementController::class, 'store'])
        ->name('store')
        ->middleware('permission:admin.announcement.edit');

    Route::group([
        'prefix' => '{announcement}',
        'middleware' => 'permission:admin.announcement.list',
    ], function () {
        Route::get('edit', [AnnouncementController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Announcement $announcement) {
                $trail->parent('admin.announcement.index', $announcement)
                    ->push(
                        __('Edit'),
                        route('admin.announcement.edit', $announcement)
                    );
            });

        Route::patch('/', [AnnouncementController::class, 'update'])
            ->name('update');
        Route::delete('/', [AnnouncementController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:admin.announcement.destore');
    });

    Route::group([
        'prefix' => '{deletedAnnouncement}',
        'middleware' => 'permission:admin.announcement.destore',
    ], function () {
        Route::patch('restore', [DeletedAnnouncementController::class, 'update'])
            ->name('restore');
        Route::delete('permanently-delete', [DeletedAnnouncementController::class, 'destroy'])
            ->name('permanently-delete');
    });

    Route::get('deactivated', [DeactivatedAnnouncementController::class, 'index'])
        ->name('deactivated')
        ->middleware('permission:admin.announcement.deactivate')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.announcement.index')
                ->push(
                    __('Deactivated Announcements'),
                    route('admin.announcement.deactivated')
                );
        });

    Route::get('/', [AnnouncementController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push(
                    __('Announcement Management'),
                    route('admin.announcement.index')
                );
        });

    Route::group([
        'prefix' => '{announcement}',
    ], function () {
        Route::get('/', [AnnouncementController::class, 'show'])
            ->name('show')
            ->breadcrumbs(function (Trail $trail, Announcement $announcement) {
                $trail->parent('admin.announcement.index')
                    ->push(
                        $announcement->message,
                        route('admin.announcement.show', $announcement)
                    );
            });

        Route::patch('mark/{status}', [DeactivatedAnnouncementController::class, 'update'])
            ->name('mark')
            ->where(['status' => '[0,1]'])
            ->middleware('permission:admin.announcement.deactivate');
    });
});
