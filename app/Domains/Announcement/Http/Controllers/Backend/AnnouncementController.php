<?php

namespace App\Domains\Announcement\Http\Controllers\Backend;

use App\Domains\Announcement\Http\Requests\Backend\StoreAnnouncementRequest;
use App\Domains\Announcement\Http\Requests\Backend\UpdateAnnouncementRequest;
use App\Domains\Announcement\Models\Announcement;
use App\Domains\Announcement\Services\AnnouncementService;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;

class AnnouncementController extends Controller
{
    protected AnnouncementService $service;

    public function __construct(AnnouncementService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        return view('backend.announcement.index');
    }

    public function create(): View
    {
        return view('backend.announcement.create');
    }

    public function store(StoreAnnouncementRequest $request): Redirector
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.announcement.index')
            ->withFlashSuccess(__('The announcement was successfully created.'));
    }

    public function show(Announcement $announcement): View
    {
        return view('backend.announcement.show')
            ->with('announcement', $announcement);
    }

    public function edit(Announcement $announcement): View
    {
        return view('backend.announcement.edit')
            ->with('announcement', $announcement);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): Redirector
    {
        $this->service->update($announcement, $request->validated());

        return redirect()
            ->route('admin.announcement.index')
            ->withFlashSuccess(__('The announcement was successfully updated.'));
    }

    public function destroy(Announcement $announcement): Redirector
    {
        $this->service->delete($announcement);

        return redirect()
            ->route('admin.announcement.index')
            ->withFlashSuccess(__('The announcement was successfully deleted.'));
    }
}
