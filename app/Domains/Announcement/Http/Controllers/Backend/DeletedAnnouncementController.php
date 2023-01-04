<?php

namespace App\Domains\Announcement\Http\Controllers\Backend;

use App\Domains\Announcement\Models\Announcement;
use App\Domains\Announcement\Services\AnnouncementService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;

class DeletedAnnouncementController extends Controller
{
    protected AnnouncementService $service;

    public function __construct(AnnouncementService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        return view('backend.announcement.deleted');
    }

    public function update(Announcement $deletedAnnouncement): Redirector
    {
        $this->service->restore($deletedAnnouncement);

        return redirect()
            ->route('admin.announcement.index')
            ->withFlashSuccess(__('The announcement was successfully restored.'));
    }

    public function destroy(Announcement $deletedAnnouncement): Redirector
    {
        $this->service->destroy($deletedAnnouncement);

        return redirect()
            ->route('admin.announcement.deleted')
            ->withFlashSuccess(__('The announcement was permanently deleted.'));
    }
}
