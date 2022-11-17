<?php

namespace App\Domains\ShortUrls\Http\Controllers\Backend;

use App\Domains\ShortUrls\Models\ShortUrls;
use App\Domains\ShortUrls\Services\ShortUrlService;
use App\Http\Controllers\Controller;

/**
 * Class ShortUrlsController.
 */
class ShortUrlsController extends Controller
{
    /**
     * @var ShortUrlService
     */
    protected $service;

    /**
     * ShortUrlsController constructor.
     *
     * @param  ShortUrlService  $service
     */
    public function __construct(ShortUrlService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.shorturls.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.shorturls.create');
    }

    /**
     * @param  StoreShortUrlsRequest  $request
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreShortUrlsRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.shorturls.index')
            ->withFlashSuccess(__('The short urls was successfully created.'));
    }

    /**
     * @param  ShortUrls  $urls
     * @return mixed
     */
    public function show(ShortUrls $urls)
    {
        return view('backend.shorturls.show')
            ->with('urls', $urls);
    }

    /**
     * @param  EditShortUrlsRequest  $request
     * @param  ShortUrls  $urls
     * @return mixed
     */
    public function edit(EditShortUrlsRequest $request, ShortUrls $urls)
    {
        return view('backend.shorturls.edit')
            ->with('urls', $urls);
    }

    /**
     * @param  UpdateShortUrlsRequest  $request
     * @param  ShortUrls  $urls
     * @return mixed
     *
     * @throws \Throwable
     */
    public function update(UpdateShortUrlsRequest $request, ShortUrls $urls)
    {
        $this->service->update($urls, $request->validated());

        return redirect()
            ->route('admin.shorturls.index')
            ->withFlashSuccess(__('The short urls was successfully updated.'));
    }

    /**
     * @param  DeleteShortUrlsRequest  $request
     * @param  ShortUrls  $urls
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(DeleteShortUrlsRequest $request, ShortUrls $urls)
    {
        $this->service->delete($urls);

        return redirect()
            ->route('admin.shorturls.index')
            ->withFlashSuccess(__('The short urls was successfully deleted.'));
    }
}
