<?php

namespace App\Domains\Announcement\Http\Controllers\Backend;

use App\Domains\Announcement\Models\Announcement;
use App\Domains\Announcement\Services\AnnouncementService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class DeactivatedAnnouncementController extends Controller
{
    protected AnnouncementService $service;

    public function __construct(AnnouncementService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        return view('backend.announcement.deactivated');
    }

    public function update(Request $request, Announcement $announcement, int $status): Redirector
    {
        $this->service->mark($announcement, $status);

        return redirect()->route(
            (int) $status === 1 || ! $request->user()->can('admin.announcement.reactivate')
                ? 'admin.announcement.index'
                : 'admin.announcement.deactivated'
        )->withFlashSuccess(__('The announcement was successfully updated.'));
    }
}
